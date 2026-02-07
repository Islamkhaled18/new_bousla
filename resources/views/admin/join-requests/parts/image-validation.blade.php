<script>
        const deleteImageRoute = "{{ route('join-requests.images.destroy', ':id') }}";
        // دالة حذف الصورة
        function deleteImage(imageId) {
            if (confirm('هل أنت متأكد من حذف هذه الصورة؟')) {

                let url = deleteImageRoute.replace(':id', imageId);

                fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('حدث خطأ أثناء حذف الصورة');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('حدث خطأ أثناء حذف الصورة');
                    });
            }
        }


        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('joinRequestForm');
            const maxSize = 5; // بالميجابايت

            // جلب كل حقول الصور
            const imageInputs = document.querySelectorAll('input[type="file"][accept="image/*"]');

            // إضافة مستمع لكل حقل صورة
            imageInputs.forEach(function(imageInput) {
                const imageError = imageInput.parentElement.querySelector('.text-danger[id="imageError"]');

                // التحقق من حجم الصورة عند اختيارها
                imageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    imageError.style.display = 'none';
                    imageError.textContent = '';

                    if (file) {
                        const fileSize = file.size / 1024 / 1024; // تحويل إلى ميجابايت

                        if (fileSize > maxSize) {
                            imageError.textContent =
                                `حجم الصورة (${fileSize.toFixed(2)} ميجابايت) أكبر من الحد المسموح (${maxSize} ميجابايت)`;
                            imageError.style.display = 'block';
                            imageInput.value = ''; // مسح الملف
                        }
                    }
                });
            });

            // التحقق قبل إرسال الفورم
            form.addEventListener('submit', function(e) {
                let hasError = false;
                let firstError = null;

                imageInputs.forEach(function(imageInput) {
                    const file = imageInput.files[0];
                    const imageError = imageInput.parentElement.querySelector(
                        '.text-danger[id="imageError"]');

                    if (file) {
                        const fileSize = file.size / 1024 / 1024;

                        if (fileSize > maxSize) {
                            e.preventDefault();
                            hasError = true;

                            imageError.textContent =
                                `حجم الصورة (${fileSize.toFixed(2)} ميجابايت) أكبر من الحد المسموح (${maxSize} ميجابايت)`;
                            imageError.style.display = 'block';

                            // حفظ أول خطأ للتمرير إليه
                            if (!firstError) {
                                firstError = imageError;
                            }
                        }
                    }
                });

                // التمرير إلى أول رسالة خطأ
                if (firstError) {
                    firstError.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }

                if (hasError) {
                    return false;
                }
            });
        });
    </script>