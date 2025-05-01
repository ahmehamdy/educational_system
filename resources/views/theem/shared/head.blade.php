<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">

<title>E-Learning Platform</title>
<meta content="" name="description">
<meta content="" name="keywords">

<!-- Favicons -->
<link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
<link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

<!-- Google Fonts -->
<link href="https://fonts.gstatic.com" rel="preconnect">
<link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

<!-- Template Main CSS File -->
<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    /* التصميم العام */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background-color: #f8f9fa;
        color: #333;
        line-height: 1.6;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    /* قسم الهيرو */
    .hero {
        text-align: center;
        padding: 80px 20px;
        background: linear-gradient(135deg, #6e48aa 0%, #9d50bb 100%);
        color: white;
        border-radius: 10px;
        margin-bottom: 40px;
    }

    .hero h1 {
        font-size: 2.5rem;
        margin-bottom: 20px;
    }

    .hero-stats {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin: 30px 0;
    }

    .stat-item {
        background: rgba(255, 255, 255, 0.2);
        padding: 15px 25px;
        border-radius: 8px;
    }

    /* قسم الخدمات */
    .services {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }

    .service-card {
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .service-card h3 {
        color: #6e48aa;
        margin-bottom: 15px;
    }

    /* قسم الفئات */
    .audience {
        display: flex;
        justify-content: center;
        gap: 40px;
        margin-bottom: 40px;
    }

    .audience-btn {
        background: #6e48aa;
        color: white;
        padding: 15px 30px;
        border: none;
        border-radius: 8px;
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .audience-btn:hover {
        background: #9d50bb;
        transform: translateY(-3px);
    }

    /* قسم أدوات المعلمين */
    .teacher-tools {
        background: white;
        padding: 40px;
        border-radius: 10px;
        margin-bottom: 40px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .teacher-tools h2 {
        color: #6e48aa;
        margin-bottom: 20px;
        text-align: center;
    }

    /* قسم إدارة الصف */
    .class-management {
        background: linear-gradient(135deg, #9d50bb 0%, #6e48aa 100%);
        color: white;
        padding: 40px;
        border-radius: 10px;
        margin-bottom: 40px;
    }

    /* قسم النشرة البريدية */
    .newsletter {
        text-align: center;
        padding: 40px 20px;
    }

    .newsletter input {
        padding: 12px 20px;
        width: 300px;
        border: 1px solid #ddd;
        border-radius: 8px 0 0 8px;
        font-size: 1rem;
    }

    .newsletter button {
        padding: 12px 20px;
        background: #6e48aa;
        color: white;
        border: none;
        border-radius: 0 8px 8px 0;
        font-size: 1rem;
        cursor: pointer;
    }

    /* التذييل */
    footer {
        text-align: center;
        padding: 20px;
        background: #333;
        color: white;
        margin-top: 40px;
    }

    .navbar {
        background-color: #6e48aa;
        padding: 15px 0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .nav-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 20px;
    }

    .logo {
        color: white;
        font-weight: bold;
        font-size: 1.5rem;
    }

    .nav-links {
        display: flex;
        gap: 25px;
    }

    .nav-links a {
        color: white;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
        padding: 5px 10px;
        border-radius: 5px;
    }

    .nav-links a:hover {
        background-color: rgba(255, 255, 255, 0.2);
    }

    .auth-buttons {
        display: flex;
        gap: 15px;
    }

    .auth-btn {
        padding: 8px 20px;
        border-radius: 5px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
    }

    .login-btn {
        background: transparent;
        color: white;
        border: 1px solid white;
    }

    .signup-btn {
        background: white;
        color: #6e48aa;
        border: 1px solid white;
    }

    /* Post Header */
    .post-header {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .post-title {
        font-size: 1.8rem;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .post-meta {
        display: flex;
        align-items: center;
        gap: 15px;
        color: #7f8c8d;
        font-size: 0.9rem;
    }

    /* Post Content */
    .post-content {
        margin-bottom: 30px;
        line-height: 1.8;
    }

    /* Comments Section */
    .comments-section {
        margin-top: 40px;
    }

    .comments-title {
        font-size: 1.3rem;
        margin-bottom: 20px;
        color: #2c3e50;
    }

    .comment-form {
        margin-bottom: 30px;
    }

    .comment-form textarea {
        width: 100%;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        resize: vertical;
        min-height: 100px;
        margin-bottom: 10px;
    }

    .comment-form button {
        background: #4a6fa5;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .comment-form button:hover {
        background: #3a5a80;
    }


    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .page-title {
        font-size: 1.75rem;
        color: #1e293b;
        font-weight: 600;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background-color: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background-color: #2563eb;
    }

    /* Posts Table */
    .posts-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .posts-table th,
    .posts-table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }

    .posts-table th {
        background-color: #f1f5f9;
        font-weight: 600;
        color: #334155;
    }

    .posts-table tr:hover {
        background-color: #f8fafc;
    }

    .status {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 1rem;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .status-published {
        background-color: #d1fae5;
        color: #065f46;
    }

    .status-draft {
        background-color: #e0f2fe;
        color: #0369a1;
    }

    .action-btn {
        padding: 0.5rem;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        background: transparent;
        color: #64748b;
    }

    .action-btn:hover {
        color: #3b82f6;
        background-color: #e0f2fe;
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: white;
        border-radius: 0.5rem;
        width: 100%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #64748b;
    }

    .modal-body {
        padding: 1.5rem;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #334155;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        font-size: 1rem;
        transition: border-color 0.2s;
    }

    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-textarea {
        min-height: 150px;
        resize: vertical;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .page-title {
        font-size: 28px;
        color: #1e293b;
    }

    .create-post-btn {
        background-color: #3b82f6;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: background-color 0.3s;
    }

    .create-post-btn:hover {
        background-color: #2563eb;
    }

    .create-post-btn i {
        font-size: 16px;
    }

    /* Post Form */
    .post-form {
        background: white;
        border-radius: 0.5rem;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #334155;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        font-size: 1rem;
        transition: border-color 0.2s;
    }

    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-textarea {
        min-height: 200px;
        resize: vertical;
    }

    .form-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }

    .file-input-container {
        position: relative;
    }

    .file-input-label {
        display: block;
        padding: 0.75rem;
        border: 1px dashed #cbd5e1;
        border-radius: 0.375rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .file-input-label:hover {
        border-color: #3b82f6;
        background-color: #f8fafc;
    }

    .file-input {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border-width: 0;
    }

    .file-list {
        margin-top: 0.5rem;
    }

    .file-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem;
        background-color: #f1f5f9;
        border-radius: 0.25rem;
        margin-bottom: 0.25rem;
    }

    .remove-file {
        color: #ef4444;
        cursor: pointer;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background-color: #3b82f6;
        color: white;
    }

    .btn-primary:hover {
        background-color: #2563eb;
    }

    .btn-secondary {
        background-color: #e2e8f0;
        color: #334155;
    }

    .btn-secondary:hover {
        background-color: #cbd5e1;
    }

    .page-header {
        margin-bottom: 1.5rem;
    }

    .page-title {
        font-size: 1.75rem;
        color: #1e293b;
        font-weight: 600;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #3b82f6;
        text-decoration: none;
        margin-bottom: 1rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .nav-links {
            gap: 1rem;
        }

        .container {
            padding: 0 1rem;
        }

        .posts-table {
            display: block;
            overflow-x: auto;
        }
    }

    .attachment-item:hover {
        background-color: #f3f4f6;
        transition: background-color 0.2s;
    }

    .attachment-name {
        direction: ltr;
        text-align: right;
        unicode-bidi: embed;
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }

    .pagination .page-item {
        padding: 0.5rem 1rem;
        border: 1px solid #ddd;
        border-radius: 0.25rem;
    }

    .pagination .page-item.active {
        background-color: #3b82f6;
        color: white;
    }

    .post-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .post-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .attachment-item {
        transition: background-color 0.2s;
    }

    .attachment-item:hover {
        background-color: #f3f4f6;
    }

    .shadow-xs {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .bg-gradient-to-br {
        background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
    }

    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .hover-bg-light:hover {
        background-color: #f8f9fa !important;
    }

    .text-purple {
        color: #6f42c1;
    }
</style>
