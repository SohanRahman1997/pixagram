<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pixagram</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f9f9f9, #e1e8ed);
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 22px;
            color: #5f6368;
            display: flex;
            align-items: center;
        }

        .navbar-brand i {
            font-size: 26px;
            color: #673ab7;
            margin-right: 10px;
        }

        .btn-upload {
            border-radius: 30px;
            background-color: #673ab7;
            color: white;
        }

        .btn-upload i {
            margin-right: 5px;
        }

        .btn-upload:hover {
            background-color: #5e35b1;
        }

        .upload-form {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .upload-form label {
            font-weight: 600;
        }

        .post-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.04);
            margin-bottom: 30px;
            transition: 0.3s ease;
        }

        .post-card:hover {
            transform: scale(1.01);
        }

        .post-card img,
        .post-card video {
            width: 100%;
            height: 480px;
            object-fit: cover;
        }

        .timestamp {
            font-size: 13px;
            color: #888;
            margin-top: 5px;
        }

        .container-inner {
            max-width: 650px;
        }

        .pagination {
            justify-content: center;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar sticky-top">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand" href="#">
            <i class="bi bi-camera2"></i> Pixagram
        </a>
        <a href="#upload-section" class="btn btn-upload">
            <i class="bi bi-cloud-upload"></i> Upload
        </a>
    </div>
</nav>

<!-- Main Container -->
<div class="container d-flex justify-content-center mt-5">
    <div class="w-100 container-inner">

        <!-- Upload Section -->
        <div id="upload-section" class="upload-form mb-5">
            <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="media" class="form-label">Select image or video to post</label>
                    <input type="file" name="media" id="media" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-upload w-100 mt-3">
                    <i class="bi bi-upload"></i> Share Now
                </button>
            </form>
        </div>

        <!-- Posts Loop -->
        @foreach ($posts as $post)
            <div class="card post-card">
                @if($post->media_type === 'image')
                    <img src="{{ asset('storage/' . $post->media_path) }}" alt="Uploaded Image">
                @elseif($post->media_type === 'video')
                    <video controls>
                        <source src="{{ asset('storage/' . $post->media_path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @endif
                <div class="card-body">
                    <p class="timestamp">{{ $post->created_at->diffForHumans() }}</p>
                </div>
            </div>
        @endforeach

        <!-- Pagination -->
        @if ($posts->hasPages())
            <div class="mt-4 d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        @endif

    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
