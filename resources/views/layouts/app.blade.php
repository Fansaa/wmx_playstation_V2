<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'WMX PLAY & WIN')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 1rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            gap: 0.5rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #20d3ee 0%, #0ea5e9 100%);
            color: white;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: linear-gradient(135deg, #f97315 0%, #ea580c 100%);
            color: white;
        }
        .btn-secondary:hover {
            background: linear-gradient(135deg, #ea580c 0%, #dc2626 100%);
            transform: translateY(-2px);
        }
        .btn-outline {
            background: transparent;
            border: 2px solid #6b7280;
            color: #6b7280;
        }
        .btn-outline:hover {
            background: #6b7280;
            color: white;
        }
        /* Cards */
        .card {
            background: white;
            border-radius: 1.5rem;
            padding: 1.5rem;
            box-shadow: 0 10px 25px -5px rgba(32, 211, 238, 0.1);
        }
        /* Form elements */
        .form-group {
            margin-bottom: 1.25rem;
        }
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }
        .form-input, .form-textarea, .form-select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 1rem;
            font-size: 1rem;
            font-family: inherit;
            transition: all 0.2s;
        }
        .form-input:focus, .form-textarea:focus, .form-select:focus {
            outline: none;
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.2);
        }
        .form-textarea {
            resize: vertical;
            min-height: 80px;
        }
        .form-error {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        /* Alerts */
        .alert {
            padding: 1rem;
            border-radius: 1rem;
            margin-bottom: 1rem;
        }
        .alert-success {
            background: #dcfce7;
            border: 1px solid #86efac;
            color: #166534;
        }
        .alert-error {
            background: #fee2e2;
            border: 1px solid #fca5a5;
            color: #991b1b;
        }
        .alert-warning {
            background: #fef3c7;
            border: 1px solid #fcd34d;
            color: #92400e;
        }
        /* Grid */
        .grid { display: grid; gap: 1.5rem; }
        .grid-2 { grid-template-columns: repeat(2, 1fr); }
        .grid-3 { grid-template-columns: repeat(3, 1fr); }
        .grid-4 { grid-template-columns: repeat(4, 1fr); }
        @media (max-width: 768px) {
            .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; }
        }
        /* Flex utilities */
        .flex { display: flex; }
        .flex-col { flex-direction: column; }
        .items-center { align-items: center; }
        .justify-center { justify-content: center; }
        .justify-between { justify-content: space-between; }
        .gap-2 { gap: 0.5rem; }
        .gap-4 { gap: 1rem; }
        .gap-6 { gap: 1.5rem; }
        /* Text */
        .text-center { text-align: center; }
        .text-sm { font-size: 0.875rem; }
        .text-lg { font-size: 1.125rem; }
        .text-xl { font-size: 1.25rem; }
        .text-2xl { font-size: 1.5rem; }
        .text-3xl { font-size: 1.875rem; }
        .text-4xl { font-size: 2.25rem; }
        .font-bold { font-weight: 700; }
        .font-semibold { font-weight: 600; }
        .text-gray-500 { color: #6b7280; }
        .text-gray-600 { color: #4b5563; }
        .text-gray-700 { color: #374151; }
        .text-gray-800 { color: #1f2937; }
        .text-sky-500 { color: #0ea5e9; }
        .text-sky-600 { color: #0284c7; }
        .text-orange-500 { color: #f97316; }
        .text-green-600 { color: #16a34a; }
        .text-red-600 { color: #dc2626; }
        /* Spacing */
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mb-8 { margin-bottom: 2rem; }
        .mt-4 { margin-top: 1rem; }
        .mt-6 { margin-top: 1.5rem; }
        .py-8 { padding-top: 2rem; padding-bottom: 2rem; }
        .py-20 { padding-top: 5rem; padding-bottom: 5rem; }
        /* Hidden */
        .hidden { display: none !important; }
        /* Dashboard nav */
        .dashboard-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top: 1px solid #e5e7eb;
            z-index: 50;
        }
        .dashboard-nav-items {
            display: flex;
            justify-content: space-around;
            padding: 0.5rem 0;
        }
        .dashboard-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0.5rem 1rem;
            text-decoration: none;
            color: #6b7280;
            border-radius: 0.75rem;
            transition: all 0.2s;
        }
        .dashboard-nav-item:hover {
            background: rgba(14, 165, 233, 0.1);
            color: #0ea5e9;
        }
        .dashboard-nav-item.active {
            background: linear-gradient(135deg, #20d3ee 0%, #0ea5e9 100%);
            color: white;
        }
        .dashboard-nav-icon { font-size: 1.5rem; }
        .dashboard-nav-label { font-size: 0.75rem; font-weight: 500; }
        /* Status badges */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-green { background: #dcfce7; color: #166534; }
        .badge-yellow { background: #fef3c7; color: #92400e; }
        .badge-red { background: #fee2e2; color: #991b1b; }
        .badge-blue { background: #dbeafe; color: #1e40af; }
        .badge-gray { background: #f3f4f6; color: #374151; }
        /* Table */
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 1rem; text-align: left; }
        .table th { background: #f3f4f6; font-weight: 600; color: #374151; }
        .table tr:not(:last-child) { border-bottom: 1px solid #e5e7eb; }
        /* Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .modal-content {
            background: white;
            border-radius: 1.5rem;
            padding: 1.5rem;
            max-width: 28rem;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
        }
    </style>
    @stack('styles')
</head>
<body>
    @if(session('success'))
        <div class="alert alert-success container" style="margin-top: 1rem;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error container" style="margin-top: 1rem;">
            <ul style="margin: 0; padding-left: 1rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')

    @stack('scripts')
</body>
</html>
