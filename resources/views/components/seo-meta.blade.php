@props([
    'title' => 'Portal Desa — Buat Halaman Desa dalam 5 Menit',
    'description' => 'Platform termudah untuk membuat halaman resmi desa. Pilih template, isi data, dan halaman desa Anda siap diakses publik dalam hitungan menit.',
    'image' => asset('images/logo.png'),
    'type' => 'website'
])

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ request()->url() }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:image" content="{{ $image }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ request()->url() }}">
<meta property="twitter:title" content="{{ $title }}">
<meta property="twitter:description" content="{{ $description }}">
<meta property="twitter:image" content="{{ $image }}">
