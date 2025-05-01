 <!-- ======= Footer ======= -->
 <footer id="footer" class="footer">
     <div class="copyright">
         &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
     </div>
     <div class="credits">
         <!-- All the links in the footer should remain intact. -->
         <!-- You can delete the links only if you purchased the pro version. -->
         <!-- Licensing information: https://bootstrapmade.com/license/ -->
         <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
         Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
     </div>
 </footer><!-- End Footer -->

 <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
         class="bi bi-arrow-up-short"></i></a>

 <!-- Vendor JS Files -->
 <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
 <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
 <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>
 <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
 <script src="{{ asset('assets/vendor/quill/quill.js') }}"></script>
 <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
 <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
 <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

 <!-- Template Main JS File -->
 <script src="{{ asset('assets/js/main.js') }}"></script>
 <script src="{{ asset('js/app.js') }}"></script>

 {{-- <script>
     // Show/hide schedule field based on status selection
     document.getElementById('postStatus').addEventListener('change', function() {
         const scheduleField = document.getElementById('scheduleField');
         scheduleField.style.display = this.value === 'scheduled' ? 'block' : 'none';
     });

     // Handle file selection and display
     document.getElementById('postAttachments').addEventListener('change', function(e) {
         const fileList = document.getElementById('fileList');
         fileList.innerHTML = '';

         if (this.files.length > 0) {
             Array.from(this.files).forEach((file, index) => {
                 const fileItem = document.createElement('div');
                 fileItem.className = 'file-item';
                 fileItem.innerHTML = `
                    <i class="fas fa-file-alt"></i>
                    <span>${file.name} (${(file.size / 1024 / 1024).toFixed(2)}MB)</span>
                    <span class="remove-file" onclick="removeFile(${index})">
                        <i class="fas fa-times"></i>
                    </span>
                `;
                 fileList.appendChild(fileItem);
             });
         }
     });

     function removeFile(index) {
         const input = document.getElementById('postAttachments');
         const files = Array.from(input.files);
         files.splice(index, 1);

         // Create new DataTransfer to update files
         const dataTransfer = new DataTransfer();
         files.forEach(file => dataTransfer.items.add(file));
         input.files = dataTransfer.files;

         // Trigger change event to update UI
         const event = new Event('change');
         input.dispatchEvent(event);
     }

     // Form submission
     document.getElementById('createPostForm').addEventListener('submit', function(e) {
         e.preventDefault();

         // Validate form
         const title = document.getElementById('postTitle').value.trim();
         const category = document.getElementById('postCategory').value;
         const content = document.getElementById('postContent').value.trim();
         const status = document.getElementById('postStatus').value;
         const schedule = document.getElementById('postSchedule').value;

         if (!title || !category || !content) {
             alert('Please fill in all required fields');
             return;
         }

         if (status === 'scheduled' && !schedule) {
             alert('Please select a schedule date and time');
             return;
         }

         // Form data would be submitted here
         const formData = new FormData(this);

         // In a real application, you would use AJAX to submit the form
         console.log('Form data:', Object.fromEntries(formData.entries()));

         // Simulate successful submission
         alert('Post created successfully!');
         this.reset();
         document.getElementById('fileList').innerHTML = '';
         document.getElementById('scheduleField').style.display = 'none';

         // Redirect to posts page
         window.location.href = 'posts.html';
     });
     document.getElementById('postAttachments').addEventListener('change', function() {
         const fileList = document.getElementById('fileList');
         fileList.innerHTML = '';

         for (let i = 0; i < this.files.length; i++) {
             const file = this.files[i];
             const listItem = document.createElement('div');
             listItem.style.margin = '5px 0';
             listItem.innerText = file.name + ' (' + Math.round(file.size / 1024) + ' KB)';
             fileList.appendChild(listItem);
         }
     });
     document.addEventListener('DOMContentLoaded', function() {
         const fileInput = document.getElementById('postAttachments');
         const fileList = document.getElementById('fileList');

         fileInput.addEventListener('change', function(e) {
             updateFileList(this.files);
         });

         // Handle drag and drop
         const dropArea = document.querySelector('.file-input-label');

         ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
             dropArea.addEventListener(eventName, preventDefaults, false);
         });

         function preventDefaults(e) {
             e.preventDefault();
             e.stopPropagation();
         }

         ['dragenter', 'dragover'].forEach(eventName => {
             dropArea.addEventListener(eventName, highlight, false);
         });

         ['dragleave', 'drop'].forEach(eventName => {
             dropArea.addEventListener(eventName, unhighlight, false);
         });

         function highlight() {
             dropArea.style.borderColor = '#3b82f6';
             dropArea.style.backgroundColor = '#f0f7ff';
         }

         function unhighlight() {
             dropArea.style.borderColor = '#cbd5e1';
             dropArea.style.backgroundColor = '';
         }

         dropArea.addEventListener('drop', handleDrop, false);

         function handleDrop(e) {
             const dt = e.dataTransfer;
             const files = dt.files;
             fileInput.files = files;
             updateFileList(files);
         }

         function updateFileList(files) {
             fileList.innerHTML = '';

             if (files && files.length > 0) {
                 Array.from(files).forEach((file, index) => {
                     const fileItem = document.createElement('div');
                     fileItem.className = 'file-item';

                     const icon = getFileIcon(file.name);

                     fileItem.innerHTML = `
                            <div class="file-icon">
                                <i class="fas ${icon}"></i>
                            </div>
                            <div class="file-info">
                                <div class="file-name" title="${file.name}">${file.name}</div>
                                <div class="file-size">${formatFileSize(file.size)}</div>
                            </div>
                            <div class="file-remove" onclick="removeFile(${index})">
                                <i class="fas fa-times"></i>
                            </div>
                        `;

                     fileList.appendChild(fileItem);
                 });
             }
         }
     });

     function getFileIcon(filename) {
         const extension = filename.split('.').pop().toLowerCase();

         switch (extension) {
             case 'pdf':
                 return 'fa-file-pdf';
             case 'doc':
             case 'docx':
                 return 'fa-file-word';
             case 'ppt':
             case 'pptx':
                 return 'fa-file-powerpoint';
             case 'xls':
             case 'xlsx':
                 return 'fa-file-excel';
             case 'jpg':
             case 'jpeg':
             case 'png':
             case 'gif':
                 return 'fa-file-image';
             case 'zip':
             case 'rar':
                 return 'fa-file-archive';
             default:
                 return 'fa-file';
         }
     }

     function formatFileSize(bytes) {
         if (bytes === 0) return '0 Bytes';

         const k = 1024;
         const sizes = ['Bytes', 'KB', 'MB', 'GB'];
         const i = Math.floor(Math.log(bytes) / Math.log(k));

         return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
     }

     function removeFile(index) {
         const fileInput = document.getElementById('postAttachments');
         const files = Array.from(fileInput.files);
         files.splice(index, 1);

         // Create new DataTransfer to update files
         const dataTransfer = new DataTransfer();
         files.forEach(file => dataTransfer.items.add(file));
         fileInput.files = dataTransfer.files;

         // Update the file list display
         updateFileList(fileInput.files);
     }

     function updateFileList(files) {
         const fileList = document.getElementById('fileList');
         fileList.innerHTML = '';

         if (files && files.length > 0) {
             Array.from(files).forEach((file, index) => {
                 const fileItem = document.createElement('div');
                 fileItem.className = 'file-item';

                 const icon = getFileIcon(file.name);

                 fileItem.innerHTML = `
                        <div class="file-icon">
                            <i class="fas ${icon}"></i>
                        </div>
                        <div class="file-info">
                            <div class="file-name" title="${file.name}">${file.name}</div>
                            <div class="file-size">${formatFileSize(file.size)}</div>
                        </div>
                        <div class="file-remove" onclick="removeFile(${index})">
                            <i class="fas fa-times"></i>
                        </div>
                    `;

                 fileList.appendChild(fileItem);
             });
         }
     }
     document.getElementById('postForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (response.ok) {
                window.location.href = "{{ route('posts.index') }}";
            } else {
                // عرض الأخطاء
                alert(result.message || 'حدث خطأ أثناء حفظ المنشور');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('حدث خطأ غير متوقع');
        }
    });
 </script> --}}
