<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Kirim ke API backend
        $apiUrl = config('app.api_url') . '/api/login';
        $response = Http::withHeaders([
            'X-Client-Secret' => config('app.client_secret'), // AMAN: di server saja
        ])->post($apiUrl, [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->failed()) {
            return back()->withErrors([
                'login' => 'Email atau password salah.',
            ]);
        }

        $data = $response->json();

        // Simpan token dan user data di session
        session([
            'api_token' => $data['token'],
            'last_login' => $data['last_login'],
            'user' => $data['user'],
            'permissions' => $data['permissions'] ?? [], // Simpan permissions di session juga sebagai backup
        ]);

        // Check if request wants JSON response (for AJAX calls)
        if ($request->expectsJson() || $request->header('Accept') === 'application/json') {
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'token' => $data['token'],
                'token_type' => $data['token_type'] ?? 'Bearer',
                'expires_at' => $data['expires_at'] ?? null,
                'last_login' => $data['last_login'],
                'user' => $data['user'],
                'permissions' => $data['permissions'] ?? []
            ]);
        }

        return redirect()->route('home');
    }

public function logout(Request $request)
    {
        // 1️⃣ Ambil token dari session (kamu simpan saat login)
        $apiToken = session('api_token');

        if ($apiToken) {
            // 2️⃣ Panggil API backend logout endpoint
            Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiToken,
                'Accept' => 'application/json',
                'X-Client-Secret' => config('app.client_secret'),
            ])->post(config('app.api_url') . '/api/logout');
        }

        // 3️⃣ Bersihkan session
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 4️⃣ Check if request wants JSON response
        if ($request->expectsJson() || $request->header('Accept') === 'application/json') {
            return response()->json([
                'success' => true,
                'message' => 'Logout successful'
            ]);
        }

        // 5️⃣ Redirect ke route default
        return redirect('/')->with('success', 'Selamat anda telah sukses logout aplikasi');
    }




public function handle(Request $request, $path)
    {
        $method = $request->method();
        $url    = config('services.api.base_url') . '/api/' . $path;

        // Buat HTTP client yang sudah inject header rahasia
        $client = Http::withHeaders([
            'X-Client-Secret' => config('services.api.client_secret'),
            'Authorization'   => session('api_token')
                     ? 'Bearer ' . session('api_token')
                     : null,
            'Accept'          => 'application/json',
        ]);

        // Untuk debug, kamu bisa gunakan dd() untuk melihat isi $client
        //dd($client);

        // Atau jika ingin melihat header saja:
        // dd($client->getOptions()['headers']);

        // Kalau ada file upload, gunakan multipart
        if ($method === 'POST' && $request->hasFile('*')) {
            $multipart = [];

            // lampirkan semua file
            foreach ($request->allFiles() as $name => $file) {
                $multipart[] = [
                    'name'     => $name,
                    'contents' => fopen($file->getRealPath(), 'r'),
                    'filename' => $file->getClientOriginalName(),
                ];
            }

            // lampirkan semua field non-file
            foreach ($request->except(array_keys($request->allFiles())) as $name => $value) {
                $multipart[] = [
                    'name'     => $name,
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

public function createInvoice(Request $request)
    {
        // Jika mau prefill dari query string:
        $prefill = $request->all();
        return view('invoice.create', compact('prefill'));
}

public function viewInvoice(Request $request)
    {
        // Jika mau prefill dari query string:
        $prefill = $request->all();
        return view('invoice.view', compact('prefill'));
}

public function proformaInvoice(Request $request)
    {
        // Jika mau prefill dari query string:
        $prefill = $request->all();
        return view('invoice.proforma', compact('prefill'));
}

}
