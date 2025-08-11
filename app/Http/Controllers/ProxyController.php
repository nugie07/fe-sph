<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProxyController extends Controller
{
public function handle1(Request $request, $path)
    {
        // 🔒 Config
        $apiBaseUrl = config('services.api.base_url');
        $clientSecret = config('app.client_secret');
        $token = session('api_token'); // Ambil dari session server-side

        // Final URL ke API backend
        $url = rtrim($apiBaseUrl, '/') . '/api/' . ltrim($path, '/');

        // 🔒 Header inject di server-side
        $client = Http::withHeaders([
            'Authorization'     => 'Bearer ' . $token,
            'X-Client-Secret'   => $clientSecret,
            'Accept'            => 'application/json',
        ]);

        // Method
        $method = $request->method();

        // Jika ada file upload
        if ($request->hasFile('*')) {
            $multipart = [];
            foreach ($request->allFiles() as $key => $file) {
                $multipart[] = [
                    'name'     => $key,
                    'contents' => fopen($file->getRealPath(), 'r'),
                    'filename' => $file->getClientOriginalName(),
                ];
            }
            foreach ($request->except(array_keys($request->allFiles())) as $key => $value) {
                $multipart[] = [
                    'name'     => $key,
                    'contents' => $value,
                ];
            }
            $response = $client->send($method, $url, ['multipart' => $multipart]);
        } else {
            // GET pakai query, selain GET pakai JSON body
            $options = $method === 'GET'
                ? ['query' => $request->query()]
                : ['json'  => $request->all()];

            $response = $client->send($method, $url, $options);
        }

        // Kembalikan response backend apa adanya
        return response($response->body(), $response->status())
               ->withHeaders([
                   'Content-Type' => $response->header('Content-Type')
               ]);
    }
public function handle(Request $request, $path)
    {
        $method = $request->method();
        \Log::info('Method: '.$method.', HasFile: '.json_encode($request->hasFile('file')));
        \Log::info('Files: '.json_encode($request->allFiles()));
        \Log::info('All: '.json_encode($request->all()));
        $url    = config('services.api.base_url') . '/api/' . $path;

        // Buat HTTP client yang sudah inject header rahasia
        $client = Http::withHeaders([
            'X-Client-Secret' => config('services.api.client_secret'),
            'Authorization'   => session('api_token')
                                 ? 'Bearer ' . session('api_token')
                                 : null,
            'Accept'          => 'application/json',
        ]);

        // Kalau ada file upload, gunakan multipart
        if (in_array($method, ['POST','PUT','PATCH']) && ($request->hasFile('file') || count($request->allFiles()) > 0)) {
            $multipart = [];

            // lampirkan semua file
            foreach ($request->allFiles() as $name => $file) {
                $multipart[] = [
                    'name'     => $name,
                    'contents' => fopen($file->getRealPath(), 'r'),
                    'filename' => $file->getClientOriginalName(),
                ];
            }

            // lampirkan semua field non-file, encode array as JSON
            foreach ($request->except(array_keys($request->allFiles())) as $name => $value) {
                if (is_array($value)) {
                    $multipart[] = [
                        'name'     => $name,
                        'contents' => json_encode($value),
                    ];
                } else {
                    $multipart[] = [
                        'name'     => $name,
                        'contents' => $value,
                    ];
                }
            }

            $response = $client->send($method, $url, ['multipart' => $multipart]);
        } else {
            // GET pakai query, selain GET pakai JSON body
            $options = $method === 'GET'
                     ? ['query' => $request->query()]
                     : ['json'  => $request->all()];

            $response = $client->send($method, $url, $options);
        }

        // Convert ke PSR-7 untuk akses header aslinya
        $psr  = $response->toPsrResponse();
        $body = (string) $psr->getBody();

        // Pilih hanya header “aman” untuk diteruskan ke client
        $safeHeaders = [];
        foreach ($psr->getHeaders() as $name => $values) {
            $lower = strtolower($name);
            if (in_array($lower, [
                'content-type',
                'content-disposition',
                'cache-control',
                'expires',
                'pragma'
            ])) {
                $safeHeaders[$name] = implode('; ', $values);
            }
        }

        // Kembalikan response dengan body, status, dan header yang telah difilter
        return response($body, $psr->getStatusCode())
               ->withHeaders($safeHeaders);
    }
}
