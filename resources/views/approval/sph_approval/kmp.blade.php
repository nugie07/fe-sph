<!-- SPH Modal Detail Confirmation for KMP Template -->
<div class="modal fade" id="modalConfirmationKmp" tabindex="-1" aria-labelledby="modalConfirmationKmpLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title fw-bold text-dark" id="modalConfirmationKmpLabel">Detail SPH - KMP</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Table detail -->
        <table class="table table-bordered mb-4">
          <tbody>
            <tr><th width="35%">Tipe SPH</th><td id="kmp-detail-tipe-sph"></td></tr>
            <tr><th>No SPH</th><td id="kmp-detail-no-sph"></td></tr>
            <tr><th>Nama Perusahaan</th><td id="kmp-detail-comp-name"></td></tr>
            <tr><th>Produk Dibeli</th><td id="kmp-detail-product"></td></tr>
            <tr><th>Metode Pembayaran</th><td id="kmp-detail-pay-method"></td></tr>
            <tr><th>Nilai Susut</th><td id="kmp-detail-susut"></td></tr>
            <tr><th>Note Berlaku</th><td id="kmp-detail-note-berlaku"></td></tr>
          </tbody>
        </table>

        <!-- Detail OAT per Customer (Kalsel & Kalteng) -->
        <div class="mb-4">
          <label class="fw-bold mb-2 fs-5">Detail OAT per Customer</label>
          
          <!-- Tabel Lokasi Kalsel -->
          <div class="mb-4">
            <h6 class="fw-bold mb-2">Lokasi Kalsel</h6>
            <div class="table-responsive theme-scrollbar">
              <table class="display table table-bordered" id="table-kmp-kalsel" style="width:100%">
                <thead>
                  <tr>
                    <th>Lokasi Kalsel</th>
                    <th>Qty / KL</th>
                    <th>Harga Dasar</th>
                    <th>PPN</th>
                    <th>Total</th>
                    <th>Transport</th>
                    <th>Grand Total</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>

          <!-- Tabel Lokasi Kalteng -->
          <div class="mb-4">
            <h6 class="fw-bold mb-2">Lokasi Kalteng</h6>
            <div class="table-responsive theme-scrollbar">
              <table class="display table table-bordered" id="table-kmp-kalteng" style="width:100%">
                <thead>
                  <tr>
                    <th>Lokasi Kalteng</th>
                    <th>Qty / KL</th>
                    <th>Harga Dasar</th>
                    <th>PPN</th>
                    <th>Total</th>
                    <th>Transport</th>
                    <th>Grand Total</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Riwayat Remark Approval -->
        <div class="mb-4">
          <label class="fw-bold mb-2">Riwayat Remark:</label>
          <ul class="list-unstyled mb-0" id="kmp-remarkHistory"></ul>
        </div>

        <!-- Konfirmasi Approval -->
        <div class="mb-3">
          <label class="form-label fw-bold mb-2">Konfirmasi Approval:</label><br>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="kmp_approval_status" id="kmp-radioApprove" value="approve">
            <label class="form-check-label" for="kmp-radioApprove">Approve</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="kmp_approval_status" id="kmp-radioRevisi" value="revisi">
            <label class="form-check-label" for="kmp-radioRevisi">Revisi</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="kmp_approval_status" id="kmp-radioReject" value="reject">
            <label class="form-check-label" for="kmp-radioReject">Reject</label>
          </div>
        </div>
        <div class="mb-2">
          <label for="kmp-approvalComment" class="form-label fw-bold">Komentar / Remark</label>
          <textarea class="form-control" id="kmp-approvalComment" name="kmp-approvalComment" rows="3" placeholder="Tulis komentar atau alasan..."></textarea>
        </div>
      </div> <!-- end modal-body -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-3 px-4" data-bs-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-success rounded-3 px-4" id="btnSaveApprovalKmp">Simpan</button>
      </div>
    </div> <!-- end modal-content -->
  </div> <!-- end modal-dialog -->
</div> <!-- end modal -->

<script>
  // Make functions globally accessible
  window.formatRupiahKmp = function(value) {
    if (value === null || value === undefined || value === '') return '';
    var str = String(value).trim();
    // Remove any non-digit, dot, comma (keep signs)
    str = str.replace(/[^0-9,.-]/g, '');
    // Normalize: remove thousand dots, replace comma with dot for decimals
    str = str.replace(/\.(?=\d{3}(\D|$))/g, '');
    str = str.replace(/,/g, '.');
    var num = parseFloat(str);
    if (isNaN(num)) num = 0;
    return 'Rp ' + num.toLocaleString('id-ID', { minimumFractionDigits: 2 });
  };

  // Function to show KMP approval modal - make it globally accessible
  window.showKmpApprovalModal = function(sphId, item) {
    // Clear previous data
    $('#kmp-detail-tipe-sph').text('');
    $('#kmp-detail-no-sph').text('');
    $('#kmp-detail-comp-name').text('');
    $('#kmp-detail-product').text('');
    $('#kmp-detail-pay-method').text('');
    $('#kmp-detail-susut').text('');
    $('#kmp-detail-note-berlaku').text('');
    
    // Fill basic info
    $('#kmp-detail-tipe-sph').text(item.tipe_sph || '');
    $('#kmp-detail-no-sph').text(item.no_sph || '');
    $('#kmp-detail-comp-name').text(item.nama_perusahaan || '');
    $('#kmp-detail-product').text(item.produk_dibeli || '');
    $('#kmp-detail-pay-method').text(item.metode_pembayaran || item.pay_method || '');
    $('#kmp-detail-susut').text(item.susut || '');
    $('#kmp-detail-note-berlaku').text(item.note_berlaku || '');

    // Set sphId on modal
    $('#modalConfirmationKmp').data('sph-id', sphId);

    // Reset radio & textarea
    $('input[name="kmp_approval_status"]').prop('checked', false);
    $('#kmp-approvalComment').val('');

    // Load details - try from item first, then from API
    var details = null;
    if (item && item.details && Array.isArray(item.details) && item.details.length > 0) {
      details = item.details;
      renderKmpTables(details);
    } else {
      // Fetch from API if details not in item
      // Try approval/details first
      $.get('/api/approval/details')
        .done(function(res) {
          // Find the specific SPH item
          var sphItem = null;
          if (res.data && res.data.sph && res.data.sph.items) {
            sphItem = res.data.sph.items.find(function(it) {
              return String(it.id) === String(sphId);
            });
          }

          if (sphItem && sphItem.details && Array.isArray(sphItem.details) && sphItem.details.length > 0) {
            details = sphItem.details;
            renderKmpTables(details);
            return;
          }

          // If still no details, try direct SPH detail API
          $.get('/api/sph/' + sphId)
            .done(function(sphDetail) {
              if (sphDetail && sphDetail.details && Array.isArray(sphDetail.details)) {
                details = sphDetail.details;
                renderKmpTables(details);
              } else {
                console.warn('No details found for SPH ID:', sphId);
                // Clear tables
                if ($.fn.DataTable.isDataTable('#table-kmp-kalsel')) {
                  $('#table-kmp-kalsel').DataTable().clear().draw();
                }
                if ($.fn.DataTable.isDataTable('#table-kmp-kalteng')) {
                  $('#table-kmp-kalteng').DataTable().clear().draw();
                }
              }
            })
            .fail(function(xhr) {
              console.error('Failed to load SPH detail:', xhr);
              Swal.fire('Error', 'Gagal memuat detail SPH', 'error');
            });
        })
        .fail(function(xhr) {
          console.error('Failed to load approval details:', xhr);
          // Try direct SPH detail API as fallback
          $.get('/api/sph/' + sphId)
            .done(function(sphDetail) {
              if (sphDetail && sphDetail.details && Array.isArray(sphDetail.details)) {
                details = sphDetail.details;
                renderKmpTables(details);
              } else {
                Swal.fire('Error', 'Gagal memuat detail SPH', 'error');
              }
            })
            .fail(function(xhr2) {
              console.error('Failed to load SPH detail:', xhr2);
              Swal.fire('Error', 'Gagal memuat detail SPH', 'error');
            });
        });
    }

    function renderKmpTables(details) {
      if (!details || !Array.isArray(details)) {
        console.warn('Invalid details data');
        return;
      }

        // Separate Kalsel and Kalteng locations
        // Based on the data structure, we need to identify which locations are Kalsel and which are Kalteng
        // From the example: Kalsel = Sesulung Estate, Desa Betung
        // Kalteng = Pundu Pantai Harapan, Gunung Mas KHS, Mustika Sembuluh, Desa Amin, Gunung Makmur, Simpang Seluncing
        
        var kalselLocations = ['Sesulung Estate', 'Desa Betung'];
        var kaltengLocations = ['Pundu Pantai Harapan', 'Gunung Mas KHS', 'Mustika Sembuluh', 'Desa Amin', 'Gunung Makmur', 'Simpang Seluncing'];

        var kalselData = [];
        var kaltengData = [];

        // Group by location and qty
        var locationGroups = {};
        details.forEach(function(detail) {
          var locName = detail.biaya_lokasi || detail.cname_lname || '';
          if (!locationGroups[locName]) {
            locationGroups[locName] = [];
          }
          locationGroups[locName].push(detail);
        });

        // Process each location group
        Object.keys(locationGroups).forEach(function(locName) {
          var group = locationGroups[locName];
          var isKalsel = kalselLocations.indexOf(locName) !== -1;
          var isKalteng = kaltengLocations.indexOf(locName) !== -1;

          if (isKalsel) {
            group.forEach(function(detail) {
              kalselData.push({
                lokasi: locName,
                qty: detail.qty || 0,
                harga_dasar: formatRupiahKmp(detail.price_liter || 0),
                ppn: formatRupiahKmp(detail.ppn || 0),
                total: formatRupiahKmp(detail.total_price || 0),
                transport: formatRupiahKmp(detail.transport || 0),
                grand_total: formatRupiahKmp(detail.grand_total || 0)
              });
            });
          } else if (isKalteng) {
            group.forEach(function(detail) {
              kaltengData.push({
                lokasi: locName,
                qty: detail.qty || 0,
                harga_dasar: formatRupiahKmp(detail.price_liter || 0),
                ppn: formatRupiahKmp(detail.ppn || 0),
                total: formatRupiahKmp(detail.total_price || 0),
                transport: formatRupiahKmp(detail.transport || 0),
                grand_total: formatRupiahKmp(detail.grand_total || 0)
              });
            });
          }
        });

        // Initialize or reload Kalsel DataTable
        if ($.fn.DataTable.isDataTable('#table-kmp-kalsel')) {
          $('#table-kmp-kalsel').DataTable().clear().rows.add(kalselData).draw();
        } else {
          $('#table-kmp-kalsel').DataTable({
            searching: false,
            paging: false,
            info: false,
            autoWidth: false,
            data: kalselData,
            columns: [
              { data: 'lokasi', title: 'Lokasi Kalsel' },
              { data: 'qty', title: 'Qty / KL', className: 'text-center' },
              { data: 'harga_dasar', title: 'Harga Dasar', className: 'text-end' },
              { data: 'ppn', title: 'PPN', className: 'text-end' },
              { data: 'total', title: 'Total', className: 'text-end' },
              { data: 'transport', title: 'Transport', className: 'text-end' },
              { data: 'grand_total', title: 'Grand Total', className: 'text-end' }
            ]
          });
        }

      // Initialize or reload Kalteng DataTable
      if ($.fn.DataTable.isDataTable('#table-kmp-kalteng')) {
        $('#table-kmp-kalteng').DataTable().clear().rows.add(kaltengData).draw();
      } else {
        $('#table-kmp-kalteng').DataTable({
          searching: false,
          paging: false,
          info: false,
          autoWidth: false,
          data: kaltengData,
          columns: [
            { data: 'lokasi', title: 'Lokasi Kalteng' },
            { data: 'qty', title: 'Qty / KL', className: 'text-center' },
            { data: 'harga_dasar', title: 'Harga Dasar', className: 'text-end' },
            { data: 'ppn', title: 'PPN', className: 'text-end' },
            { data: 'total', title: 'Total', className: 'text-end' },
            { data: 'transport', title: 'Transport', className: 'text-end' },
            { data: 'grand_total', title: 'Grand Total', className: 'text-end' }
          ]
        });
      }
    }

    // Load remarks
    $('#kmp-remarkHistory').html('<li class="text-center py-2"><div class="spinner-border text-primary"></div> Memuat riwayat…</li>');
    if (typeof loadRemarks === 'function') {
      loadRemarks(sphId, 'sph', '#kmp-remarkHistory');
    } else {
      $.get(`/api/remarks/${sphId}?tipe_trx=sph`)
        .done(function(remarks) {
          if (!remarks.length) {
            $('#kmp-remarkHistory').html('<li class="text-muted">Belum ada remark</li>');
            return;
          }
          var html = remarks.map(function(r) {
            var color = 'primary';
            var user = r.user || r.last_updateby || 'User';
            var comment = r.comment || r.wf_comment || '';
            if (comment.toLowerCase().includes('approve')) color = 'success';
            if (comment.toLowerCase().includes('reject')) color = 'danger';
            var created = r.created_at
              ? new Date(r.created_at).toLocaleDateString('id-ID', { year: 'numeric', month: 'long', day: 'numeric' })
              : '';
            return `<li class="mb-2 pb-2 border-bottom">
              <span class="fw-bold text-${color}">• ${user}</span> -
              <span>${comment}</span>
              <span class="text-muted ms-2 small">(${created})</span>
            </li>`;
          }).join('');
          $('#kmp-remarkHistory').html(html);
        })
        .fail(function() {
          $('#kmp-remarkHistory').html('<li class="text-danger">Gagal memuat riwayat.</li>');
        });
    }

    // Show modal
    $('#modalConfirmationKmp').modal('show');
  };

  // Handler tombol Simpan di modal KMP
  $(document).on('click', '#btnSaveApprovalKmp', function() {
    var sphId = $('#modalConfirmationKmp').data('sph-id');
    var status = $('input[name="kmp_approval_status"]:checked').val();
    var comment = $('#kmp-approvalComment').val().trim();

    if (!status) {
      Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Pilih status Approve, Revisi, atau Reject.' });
      return;
    }
    if (!comment) {
      Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Komentar wajib diisi.' }).then(() => {
        $('#kmp-approvalComment').focus();
      });
      return;
    }

    var $btn = $(this);
    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Menyimpan...');

    $.ajax({
      url: '/api/sph/' + sphId + '/approval',
      type: 'POST',
      data: {
        approval_status: status,
        approvalComment: comment
      },
      success: function(res) {
        Swal.fire('Berhasil', res.message, 'success');
        $('#modalConfirmationKmp').modal('hide');
        $btn.prop('disabled', false).html('Simpan');
        // Reload page or refresh table
        if (typeof fetchSph === 'function') {
          fetchSph();
        } else {
          window.location.reload();
        }
      },
      error: function(xhr) {
        Swal.fire('Gagal', xhr.responseJSON?.message || 'Gagal simpan!', 'error');
        $btn.prop('disabled', false).html('Simpan');
      }
    });
  });
</script>

