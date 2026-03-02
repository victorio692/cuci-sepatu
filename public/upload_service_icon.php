<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Icon Layanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2 text-center">
                <i class="fas fa-image text-blue-500 mr-2"></i>Upload Service Icon
            </h1>
            <p class="text-gray-600 text-center mb-6">Upload icon untuk layanan Fast Cleaning</p>

            <form id="uploadForm" class="space-y-6">
                <!-- Service Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Layanan</label>
                    <select id="service_id" name="service_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                        <option value="">-- Pilih Layanan --</option>
                        <option value="1">Fast Cleaning</option>
                        <option value="2">Deep Cleaning</option>
                        <option value="3">White Shoes</option>
                        <option value="4">Suede Treatment</option>
                        <option value="5">Unyellowing</option>
                    </select>
                </div>

                <!-- File Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Gambar</label>
                    <div class="relative border-2 border-dashed border-blue-300 rounded-lg p-6 text-center cursor-pointer hover:bg-blue-50 transition bg-blue-25">
                        <input type="file" id="icon_image" name="icon_image" accept="image/*" class="hidden" required onchange="previewImage(event)">
                        <label for="icon_image" class="cursor-pointer">
                            <i class="fas fa-cloud-upload-alt text-4xl text-blue-500 mb-2"></i>
                            <p class="text-gray-700 font-medium">Klik atau drag gambar ke sini</p>
                            <p class="text-gray-500 text-sm mt-1">Format: JPG, PNG, GIF (Max 2MB)</p>
                        </label>
                    </div>
                    <div id="previewContainer" class="mt-4 text-center" style="display: none;">
                        <img id="preview" src="" alt="Preview" class="max-h-40 mx-auto rounded-lg border border-gray-300">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:shadow-lg transform hover:scale-105 transition font-medium">
                        <i class="fas fa-upload mr-2"></i>Upload Icon
                    </button>
                    <a href="/admin/services" class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium text-center">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>

                <!-- Status Messages -->
                <div id="message" class="hidden p-4 rounded-lg text-sm"></div>
            </form>
        </div>
    </div>

    <script>
        // Preview image
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                    document.getElementById('previewContainer').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }

        // Handle form submission
        document.getElementById('uploadForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const serviceId = document.getElementById('service_id').value;
            const file = document.getElementById('icon_image').files[0];
            const messageDiv = document.getElementById('message');

            if (!file) {
                showMessage('❌ Silakan pilih gambar', 'error');
                return;
            }

            if (file.size > 2097152) {
                showMessage('❌ Ukuran file terlalu besar (max 2MB)', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('icon_image', file);

            try {
                const response = await fetch(`/api/admin/services/${serviceId}/upload-icon`, {
                    method: 'POST',
                    body: formData,
                    credentials: 'include'
                });

                const result = await response.json();
                console.log('Response:', result);

                if (result.code === 200) {
                    showMessage('✅ Icon berhasil diupload! Redirect dalam 2 detik...', 'success');
                    setTimeout(() => {
                        window.location.href = '/admin/services';
                    }, 2000);
                } else {
                    showMessage('❌ ' + (result.message || 'Gagal upload icon'), 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('❌ Error: ' + error.message, 'error');
            }
        });

        function showMessage(message, type) {
            const messageDiv = document.getElementById('message');
            messageDiv.className = `p-4 rounded-lg text-sm ${type === 'success' ? 'bg-green-100 text-green-700 border-l-4 border-green-500' : 'bg-red-100 text-red-700 border-l-4 border-red-500'}`;
            messageDiv.textContent = message;
            messageDiv.style.display = 'block';
        }

        // Drag and drop
        const dropZone = document.querySelector('.relative');
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('bg-blue-100');
        });
        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('bg-blue-100');
        });
        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('bg-blue-100');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                document.getElementById('icon_image').files = files;
                previewImage({ target: { files } });
            }
        });
    </script>
</body>
</html>