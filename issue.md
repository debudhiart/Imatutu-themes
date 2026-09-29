# SPESIFIKASI DAN PANDUAN PENGEMBANGAN: TEMA WORDPRESS IMATUTU MODERN
**Referensi Desain**: Pertamina.com (Corporate, Clean, Modern, High Performance)  
**Batasan Kunci**: **Mempertahankan 100% konten original** tanpa menambah konten fiktif baru  
**Fitur Utama**: Mendukung penuh fitur **WordPress Customizer (`WP_Customize_Manager`)**  
**Metode Distribusi**: Tema siap di-zip dan diunggah melalui **Dashboard WordPress (Appearance > Themes > Add New > Upload Theme)**  
**Target Pelaksana**: Junior Web Programmer atau Model AI (Instruksi disusun sangat detail, prosedural, dan *code-ready*)

---

## DAFTAR ISI
1. [Ringkasan Proyek & Tujuan](#1-ringkasan-proyek--tujuan)
2. [Inventaris Konten Original (Wajib Dipertahankan)](#2-inventaris-konten-original-wajib-dipertahankan)
3. [Arsitektur & Struktur Direktori Tema](#3-arsitektur--struktur-direktori-tema)
4. [Rincian Fitur WordPress Customizer (inc/customizer.php)](#4-rincian-fitur-wordpress-customizer-inccustomizerphp)
5. [Spesifikasi Teknis File Utama Tema](#5-spesifikasi-teknis-file-utama-tema)
   - 5.1 [style.css](#51-stylecss)
   - 5.2 [functions.php](#52-functionsphp)
   - 5.3 [header.php](#53-headerphp)
   - 5.4 [front-page.php & Template Parts](#54-front-pagephp--template-parts)
   - 5.5 [footer.php](#55-footerphp)
   - 5.6 [page.php & index.php](#56-pagephp--indexphp)
   - 5.7 [assets/css/main.css & assets/js/main.js](#57-assetscssmaincss--assetsjsmainjs)
6. [Tahapan Implementasi Step-by-Step (Untuk Junior / Model AI)](#6-tahapan-implementasi-step-by-step-untuk-junior--model-ai)
7. [Prosedur Packaging (.ZIP) & Deployment Dashboard](#7-prosedur-packaging-zip--deployment-dashboard)
8. [Checklist Pengujian & Verifikasi Akhir](#8-checklist-pengujian--verifikasi-akhir)

---

## 1. RINGKASAN PROYEK & TUJUAN

Tema website saat ini ([imatutu.com](https://imatutu.com/)) memiliki ketergantungan berat pada Elementor dan 9 tumpukan Envato Template Kit yang memperlambat website serta memiliki tampilan yang kaku (logo teks biasa, ketiadaan tombol CTA di hero, background hitam pekat saat scroll, dan kesalahan hirarki heading).

Tujuan dari proyek ini adalah **membangun ulang tema kustom WordPress mandiri (*standalone custom theme*)** yang:
1. Mengadopsi visual korporat modern terinspirasi dari [pertamina.com](https://pertamina.com/): tipografi jernih (Plus Jakarta Sans), navbar *glassmorphism* transparan ke solid, layout berbasis kartu yang rapi, garis aksen elegan, dan kontras tinggi.
2. Mempertahankan **seluruh teks, gambar, data kontak, dan partner original** milik Imatutu tanpa penambahan teks asing.
3. Memperbaiki aspek **SEO teknis** (tag `<h1>` yang hilang, Open Graph, meta description, image alt).
4. Menyediakan antarmuka **Customizer (Appearance > Customize)** agar seluruh teks, logo, kontak, nomor telepon, dan tautan dapat diubah langsung oleh tim non-teknis tanpa menyentuh kode.
5. Menghasilkan arsip `.zip` yang dapat langsung diunggah via menu **Themes** di admin WordPress.

---

## 2. INVENTARIS KONTEN ORIGINAL (WAJIB DIPERTAHANKAN)

Setiap bagian tema baru **HARUS** memuat data teks original berikut sebagai nilai bawaan (*default value*):

| Komponen | Data Original yang Harus Digunakan |
|---|---|
| **Header Brand** | Teks: `IMATUTU` (atau custom logo jika diunggah) |
| **Header Subtitle** | `by PT Karya Antara Negeri | PT Karya Antara Benua` |
| **Header Menu** | Home, About Us, Careers, Gallery, Contact Us |
| **Header Button** | Label: `Contact`, Link: `/contact-us/` |
| **Hero Heading 1 (H1)** | `The Trusted Choice For Your Business Support Requirements` |
| **Hero Heading 2 (Sub)** | `Integrated Solutions for All Your Business Needs` |
| **Hero Images (Slider/Grid)** | Menggunakan 7 foto operasional/tim bawaan imatutu.com |
| **Services Subtitle** | `What We OFFER` |
| **Services Main Title** | `Taylor Made Solutions for Your Business` |
| **Layanan 1** | Judul: `Customer Service Support`<br>Deskripsi: *"We provide 24/7 contact center services tailored to suit your industry needs from, handling inquiries, transport bookings, handling customer feedback and resolving issues promptly to ensure customer satisfaction. Our team is trained to deliver exceptional service in every interaction."* |
| **Layanan 2** | Judul: `Full Technical Support`<br>Deskripsi: *"Our experts offer reliable troubleshooting and technical assistance, for multiple systems helping clients resolve technical problems efficiently. We focus on quick solutions to minimize downtime."* |
| **Layanan 3** | Judul: `Administration Support`<br>Deskripsi: *"Full accounting services available, teamed up with data processing, general administration and customer service support"* |
| **Global Reach Title** | `Our Global Reach` |
| **Global Reach Desc** | *"With numerous clients, successful projects and a wide reach, Imatutu is making a mark as the preferred outsourcing partner. We support our global clients, delivering excellence in every project. Our services span across multiple countries and multiple industries, helping businesses achieve their goals globally."* |
| **Statistik Metrik** | 1. `150+` (Label: `Client`)<br>2. `150+` (Label: `Project`)<br>3. `3` (Label: `Country`) |
| **Klien / Partner (9 Logo)** | 1. Alert Taxis (`http://www.alerttaxis.co.nz`)<br>2. Canberra Elite (`http://www.canberraelite.com.au`)<br>3. NZTC (`http://www.nztc.net.nz`)<br>4. Aerial Capital Group (`http://www.aerialcapitalgroup.com.au`)<br>5. First Direct (`http://www.firstdirect.net.nz`)<br>6. PN Taxis (`http://www.pntaxis.co.nz`)<br>7. BusMe (`http://www.busme.com.au`)<br>8. Silver Service Canberra (`http://www.silverservicecanberra.com.au`)<br>9. QE Taxis (`http://www.qetaxis.com.au`) |
| **Footer Kontak 1** | `Jl. Gatot Subroto Barat No.283, Pemecutan Kaja, Kec. Denpasar Utara, Kota Denpasar, Bali 80111` |
| **Footer Kontak 2** | `Jl. Gatot Subroto Tengah No.45F, Dauh Puri Kaja, Kec. Denpasar Utara, Kota Denpasar, Bali 80239` |
| **Footer Telepon** | `+62 851 6893 2460` |
| **Footer Email** | `office@imatutu.com` |
| **Footer Tagline** | `Integrated Solutions for All Your Business Needs` |
| **Chatbot Integration** | Fastbots Script: `https://app.fastbots.ai/embed.js` dengan Bot ID: `cm8gjb24m11rmrik59ko46vdi` |

---

## 3. ARSITEKTUR & STRUKTUR DIREKTORI TEMA

Paket tema diberi nama folder: `imatutu-theme`

```
imatutu-theme/
├── assets/
│   ├── css/
│   │   └── main.css             # Styling tema modern (CSS terstruktur / Tailwind)
│   ├── js/
│   │   ├── main.js              # Script sticky header, mobile nav & slider ringan
│   │   └── customizer-preview.js# Live preview JS untuk WP Customizer
│   └── images/
│       ├── logo.svg             # Logo default (fallback jika belum upload)
│       └── placeholder.jpg      # Placeholder gambar hero & layanan
├── inc/
│   └── customizer.php           # Implementasi lengkap WP_Customize_Manager
├── template-parts/
│   ├── home/
│   │   ├── section-hero.php     # Hero section dengan tombol CTA & background
│   │   ├── section-services.php # 3 kartu layanan bergaya kartu modern
│   │   ├── section-stats.php    # Bagian Our Global Reach + 3 metrik statistik
│   │   └── section-clients.php  # Grid 9 logo partner taksi AU/NZ
│   └── content-none.php         # Tampilan fallback 404 / no content
├── 404.php                      # Halaman 404 ramah pengguna
├── footer.php                   # Footer korporat modern multi-kolom
├── front-page.php               # Template utama beranda (memanggil template-parts)
├── functions.php                # Registrasi aset, fitur tema & hooks
├── header.php                   # Navbar modern, top bar utilitas, & SEO meta
├── index.php                    # Fallback blog archive
├── page.php                     # Template standar halaman tunggal (About, Careers, dll)
├── screenshot.png               # Banner thumbnail tema (resolusi 1200x900 px)
└── style.css                    # Deklarasi metadata tema WordPress
```

---

## 4. RINCIAN FITUR WORDPRESS CUSTOMIZER (`inc/customizer.php`)

Seluruh pengaturan harus didaftarkan di hook `customize_register`. Dibuat dengan panel khusus bernama: **"Imatutu Theme Settings"** (`panel_imatutu`).

### Struktur Panel & Section Customizer:

```
[Panel] Imatutu Theme Settings (panel_imatutu)
  │
  ├── [Section 1] Colors & Brand Identity (sec_imatutu_colors)
  │     ├── Setting: primary_color (Default: #1559ED)
  │     ├── Setting: secondary_color (Default: #0B192C)
  │     └── Setting: accent_color (Default: #E21F23)
  │
  ├── [Section 2] Header Settings (sec_imatutu_header)
  │     ├── Setting: header_brand_text (Default: "IMATUTU")
  │     ├── Setting: header_subtitle (Default: "by PT Karya Antara Negeri | PT Karya Antara Benua")
  │     ├── Setting: header_cta_text (Default: "Contact")
  │     └── Setting: header_cta_link (Default: "https://imatutu.com/contact-us/")
  │
  ├── [Section 3] Hero Section (sec_imatutu_hero)
  │     ├── Setting: hero_heading_1 (Default: "The Trusted Choice For Your Business Support Requirements")
  │     ├── Setting: hero_heading_2 (Default: "Integrated Solutions for All Your Business Needs")
  │     ├── Setting: hero_bg_image (Image upload control)
  │     ├── Setting: hero_cta_primary_text (Default: "Contact Us")
  │     ├── Setting: hero_cta_primary_link (Default: "https://imatutu.com/contact-us/")
  │     ├── Setting: hero_cta_secondary_text (Default: "Our Services")
  │     └── Setting: hero_cta_secondary_link (Default: "#services")
  │
  ├── [Section 4] Services Section (sec_imatutu_services)
  │     ├── Setting: services_subtitle (Default: "What We OFFER")
  │     ├── Setting: services_title (Default: "Taylor Made Solutions for Your Business")
  │     ├── Setting: service_1_title (Default: "Customer Service Support")
  │     ├── Setting: service_1_desc (Textarea - Konten Asli)
  │     ├── Setting: service_1_image (Image upload)
  │     ├── Setting: service_2_title (Default: "Full Technical Support")
  │     ├── Setting: service_2_desc (Textarea - Konten Asli)
  │     ├── Setting: service_2_image (Image upload)
  │     ├── Setting: service_3_title (Default: "Administration Support")
  │     ├── Setting: service_3_desc (Textarea - Konten Asli)
  │     └── Setting: service_3_image (Image upload)
  │
  ├── [Section 5] Global Reach & Stats (sec_imatutu_stats)
  │     ├── Setting: stats_title (Default: "Our Global Reach")
  │     ├── Setting: stats_desc (Textarea - Konten Asli)
  │     ├── Setting: stats_side_image (Image upload)
  │     ├── Setting: stat_1_number (Default: "150+")
  │     ├── Setting: stat_1_label (Default: "Client")
  │     ├── Setting: stat_2_number (Default: "150+")
  │     ├── Setting: stat_2_label (Default: "Project")
  │     ├── Setting: stat_3_number (Default: "3")
  │     └── Setting: stat_3_label (Default: "Country")
  │
  ├── [Section 6] Partner & Client Logos (sec_imatutu_clients)
  │     ├── Setting: clients_section_title (Default: "Our Trusted Partners")
  │     └── Settings: client_1_logo s/d client_9_logo (Image upload)
  │     └── Settings: client_1_url s/d client_9_url (URL input)
  │     └── Settings: client_1_name s/d client_9_name (Text input)
  │
  └── [Section 7] Footer & Contact Info (sec_imatutu_footer)
        ├── Setting: footer_address_1 (Default: "Jl. Gatot Subroto Barat No.283, Pemecutan Kaja, Kec. Denpasar Utara, Kota Denpasar, Bali 80111")
        ├── Setting: footer_address_2 (Default: "Jl. Gatot Subroto Tengah No.45F, Dauh Puri Kaja, Kec. Denpasar Utara, Kota Denpasar, Bali 80239")
        ├── Setting: footer_phone (Default: "+62 851 6893 2460")
        ├── Setting: footer_email (Default: "office@imatutu.com")
        ├── Setting: footer_tagline (Default: "Integrated Solutions for All Your Business Needs")
        ├── Setting: fastbots_bot_id (Default: "cm8gjb24m11rmrik59ko46vdi")
        └── Setting: footer_copyright (Default: "© Copyright Imatutu. All Rights Reserved.")
```

---

## 5. SPESIFIKASI TEKNIS FILE UTAMA TEMA

### 5.1 `style.css`
File ini wajib diletakkan di root folder tema dengan header standar WordPress:

```css
/*
Theme Name: Imatutu Modern Corporate
Theme URI: https://imatutu.com
Author: Budhi Arta / Imatutu Dev Team
Author URI: https://imatutu.com
Description: Tema korporat modern dan elegan untuk Imatutu, terinspirasi dari desain enterprise Pertamina.com. Ringan, cepat, responsif, dan didukung penuh oleh WordPress Customizer.
Version: 1.0.0
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 7.4
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: imatutu
Tags: corporate, business, clean, responsive, customizer, bpo
*/
```

---

### 5.2 `functions.php`
Wajib mencakup fungsi-fungsi krusial berikut:
1. `imatutu_theme_setup()`:
   - `add_theme_support('title-tag')` (Memperbaiki title tag SEO).
   - `add_theme_support('post-thumbnails')`.
   - `add_theme_support('custom-logo')`.
   - `add_theme_support('html5', array('search-form', 'comment-form', 'gallery', 'caption'))`.
   - `register_nav_menus(array('primary' => __('Primary Menu', 'imatutu')))`
2. `imatutu_enqueue_assets()`:
   - Load font Google `Plus Jakarta Sans` via Google Fonts (`display=swap`).
   - Load `assets/css/main.css` (versi file time untuk cache busting saat development).
   - Load `assets/js/main.js` dengan atribut `defer`.
3. `require_once get_template_directory() . '/inc/customizer.php'`.
4. Sanitasi fungsi pembantu (`sanitize_text_field`, `esc_url_raw`, dll).

Contoh implementasi standar `functions.php`:
```php
<?php
if (!defined('ABSPATH')) exit;

function imatutu_setup() {
    load_theme_textdomain('imatutu', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 240,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    register_nav_menus(array(
        'primary' => __('Primary Navigation', 'imatutu'),
        'footer'  => __('Footer Navigation', 'imatutu'),
    ));
}
add_action('after_setup_theme', 'imatutu_setup');

function imatutu_scripts() {
    // Plus Jakarta Sans Font
    wp_enqueue_style('imatutu-fonts', 'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap', array(), null);
    
    // Main Stylesheet
    wp_enqueue_style('imatutu-main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0');
    wp_enqueue_style('imatutu-style', get_stylesheet_uri(), array('imatutu-main'), '1.0.0');

    // Main JavaScript
    wp_enqueue_script('imatutu-script', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'imatutu_scripts');

// Include Customizer
require_once get_template_directory() . '/inc/customizer.php';
```

---

### 5.3 `header.php`
Kunci penting perbaikan ala Pertamina:
1. **Semantic `<head>`**: Terdapat charset, viewport, link canonical, dan fallback meta description.
2. **Top Utility Bar**: Menampilkan status operasional 24/7 dan nomor kontak utama.
3. **Sticky Navbar dengan Glassmorphism**:
   - Logo: Jika ada `has_custom_logo()`, gunakan itu. Jika tidak, gunakan teks `get_theme_mod('header_brand_text', 'IMATUTU')` dengan subteks `get_theme_mod('header_subtitle')`.
   - Navigasi: `wp_nav_menu()` dengan walker modern atau clean list.
   - Tombol Aksi: Tombol `Contact` yang terhubung ke Customizer.
   - Mobile Toggle: Hamburger button minimalis SVG.

---

### 5.4 `front-page.php` & `template-parts/home/`
File `front-page.php` hanya bertindak sebagai orkestrator yang memanggil komponen:

```php
<?php
get_header();
?>
<main id="primary" class="site-main">
    <?php
    get_template_part('template-parts/home/section', 'hero');
    get_template_part('template-parts/home/section', 'services');
    get_template_part('template-parts/home/section', 'stats');
    get_template_part('template-parts/home/section', 'clients');
    ?>
</main>
<?php
get_footer();
```

#### Komponen Spesifik:
1. **`section-hero.php`**:
   - Wajib ada **1 tag `<h1>`** yang membungkus `hero_heading_1`.
   - Subjudul menggunakan `<p class="hero-subtitle">` membungkus `hero_heading_2`.
   - Dua tombol CTA: `Contact Us` (Primary) dan `Our Services` (Secondary anchor scroll).
   - Indikator live metrics strip langsung di bawah teks.
2. **`section-services.php`**:
   - Subheading: `What We OFFER`.
   - Heading (H2): `Taylor Made Solutions for Your Business`.
   - Grid 3 kolom modern dengan kartu yang memiliki efek hover elevasi lembut.
   - Bersih dari kode `mso-*` atau sisa style Microsoft Word.
3. **`section-stats.php`**:
   - Layout 2 kolom: Kiri teks deskripsi "Our Global Reach" + 3 angka statistik; Kanan gambar pendukung (`data-entry-1`).
   - Angka statistik dibungkus dengan `<span class="stat-number">` (bukan tag H2!) untuk menjaga integritas hierarki heading.
4. **`section-clients.php`**:
   - Grid 9 logo partner taksi dengan link `target="_blank"` dan `rel="noopener noreferrer"`.
   - Setiap tag `<img>` **wajib** memiliki atribut `alt` yang deskriptif (misal: `alt="Canberra Elite Taxis Partner Logo"`).
   - Efek visual monokrom elegan yang berubah menjadi warna asli saat disentuh kursor.

---

### 5.5 `footer.php`
1. Layout korporat 3 kolom:
   - **Kolom 1**: Logo putih / Nama Brand, Tagline *"Integrated Solutions for All Your Business Needs"*, dan legal entity PT.
   - **Kolom 2**: Alamat Kantor Denpasar (Kantor 1 & Kantor 2), Telepon, dan Email.
   - **Kolom 3**: Navigasi Cepat (Quick Links).
2. Baris Bawah: Copyright dinamis (`© <?php echo date('Y'); ?> Imatutu. All Rights Reserved.`).
3. Embed Script Chatbot Fastbots dinamis:
   ```php
   <?php 
   $bot_id = get_theme_mod('fastbots_bot_id', 'cm8gjb24m11rmrik59ko46vdi');
   if (!empty($bot_id)): ?>
   <script id="fastbots-chatbot-js" defer data-bot-id="<?php echo esc_attr($bot_id); ?>" src="https://app.fastbots.ai/embed.js"></script>
   <?php endif; ?>
   <?php wp_footer(); ?>
   </body>
   </html>
   ```

---

## 6. TAHAPAN IMPLEMENTASI STEP-BY-STEP (UNTUK JUNIOR / MODEL AI)

Bagi pelaksana (junior programmer atau AI), ikuti urutan kerja presisi berikut:

### Tahap 1: Persiapan Ruang Kerja Lokal
1. Buat folder bernama `imatutu-theme` di direktori lokal Anda.
2. Buat subfolder:
   - `imatutu-theme/assets/css`
   - `imatutu-theme/assets/js`
   - `imatutu-theme/assets/images`
   - `imatutu-theme/inc`
   - `imatutu-theme/template-parts/home`

### Tahap 2: Menulis Deklarasi Tema & Functions
1. Tulis file `style.css` sesuai header metadata di subbab 5.1.
2. Tulis `functions.php` sesuai subbab 5.2. Pastikan `wp_enqueue_scripts` memanggil font Google Plus Jakarta Sans dan stylesheet tema.

### Tahap 3: Membangun Modul Customizer (`inc/customizer.php`)
1. Buat fungsi `imatutu_customize_register($wp_customize)`.
2. Daftarkan panel `panel_imatutu`.
3. Daftarkan 7 section dan seluruh settings beserta controls-nya sesuai cetak biru di Bab 4.
4. **Wajib menyertakan sanitasi** untuk setiap field:
   - Teks biasa: `'sanitize_callback' => 'sanitize_text_field'`
   - Paragraf/textarea: `'sanitize_callback' => 'sanitize_textarea_field'`
   - URL: `'sanitize_callback' => 'esc_url_raw'`
   - Gambar: `'sanitize_callback' => 'esc_url_raw'`
   - Warna: `'sanitize_callback' => 'sanitize_hex_color'`

### Tahap 4: Merancang Header, Footer, dan Template Utama
1. Tulis `header.php` dengan struktur semantik modern.
2. Tulis `footer.php` dengan struktur 3 kolom dan integrasi Fastbots.
3. Tulis `front-page.php`.
4. Tulis 4 file komponen di `template-parts/home/`:
   - `section-hero.php`
   - `section-services.php`
   - `section-stats.php`
   - `section-clients.php`
   Pastikan di dalam setiap komponen, teks ditampilkan menggunakan `get_theme_mod('setting_key', 'Default Original Text')`.

### Tahap 5: Menyusun Styling Modern (`assets/css/main.css`)
Gunakan prinsip desain enterprise Pertamina:
- Warna primer: Biru korporat `#1559ED` dan Navy `#0B192C`.
- Warna latar sekunder: `#F8FAFC` (Slate lembut).
- Radius sudut: `rounded-xl` (12px) untuk kartu, `rounded-full` untuk pill badge dan tombol.
- Efek elevasi: `box-shadow: 0 4px 20px -2px rgba(0,0,0,0.06);`.
- Transisi halus: `transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);`.

### Tahap 6: Menyusun Script Interaktif Bersih (`assets/js/main.js`)
Tulis kode vanilla JavaScript tanpa jQuery:
1. **Sticky Header Handler**: Menambahkan class `is-scrolled` saat `window.scrollY > 40` untuk memicu efek background putih dan shadow halus.
2. **Mobile Nav Toggle**: Membuka dan menutup drawer menu mobile dengan animasi transisi rapi.

---

## 7. PROSEDUR PACKAGING (.ZIP) & DEPLOYMENT DASHBOARD

Setelah seluruh kode selesai ditulis di folder `imatutu-theme`:

### 1. Membuat Arsip ZIP
Kompres folder tema sehingga struktur zip adalah:
```
imatutu-theme.zip
└── imatutu-theme/
    ├── style.css
    ├── functions.php
    ├── header.php
    ├── ... (seluruh file dan subfolder)
```
*Catatan Penting*: Jangan mengompres isi foldernya saja secara langsung tanpa folder induk `imatutu-theme`, karena WordPress membutuhkan satu folder root saat mengekstrak tema.

### 2. Prosedur Instalasi via Dashboard WordPress
1. Buka browser dan login ke **WordPress Admin Dashboard** (`https://imatutu.com/wp-admin/` atau server staging lokal).
2. Di menu bilah kiri, klik **Appearance (Tampilan)** > **Themes (Tema)**.
3. Klik tombol **Add New Theme (Tambah Tema Baru)** di bagian atas.
4. Klik tombol **Upload Theme (Unggah Tema)**.
5. Klik **Choose File (Pilih Berkas)** dan pilih file `imatutu-theme.zip`.
6. Klik **Install Now (Pasang Sekarang)**.
7. Tunggu hingga proses ekstraksi selesai, lalu klik **Activate (Aktifkan)**.

### 3. Mengatur Halaman Beranda (Static Front Page)
1. Buka menu **Settings (Pengaturan)** > **Reading (Membaca)**.
2. Pada opsi *Your homepage displays*, pilih **A static page (Halaman statis)**.
3. Tetapkan *Homepage* ke halaman utama Imatutu (`Home`).
4. Klik **Save Changes**.

### 4. Konfigurasi melalui Customizer
1. Buka menu **Appearance (Tampilan)** > **Customize (Sesuaikan)**.
2. Klik panel **Imatutu Theme Settings**.
3. Di sini seluruh teks original telah muncul secara otomatis sebagai default. Pengguna dapat mengubah nomor telepon, alamat, teks hero, hingga mengganti logo partner kapan saja secara visual.
4. Klik tombol **Publish (Terbitkan)** di bagian atas Customizer.

---

## 8. CHECKLIST PENGUJIAN & VERIFIKASI AKHIR

Sebelum dinyatakan selesai (Done/Ready to Deploy), pastikan seluruh item berikut telah tercentang:

- [ ] **Kelengkapan Konten**: Seluruh 3 layanan, 3 statistik (150+, 150+, 3), dan 9 logo klien partner tampil sempurna dengan teks bawaan.
- [ ] **SEO Semantik**: Halaman beranda hanya memiliki tepat 1 tag `<h1>` di bagian Hero.
- [ ] **Alt Text Gambar**: Seluruh 9 logo klien memiliki atribut `alt` yang terisi deskriptif.
- [ ] **Fungsi Customizer**: Mengubah judul Hero di Customizer langsung mengubah teks di website saat di-*Publish*.
- [ ] **Bebas Error PHP**: Tidak ada pesan *Warning* atau *Deprecated* saat `WP_DEBUG` diaktifkan di `wp-config.php`.
- [ ] **Bebas Konflik JavaScript**: Console browser bersih dari error (tidak ada error `jQuery is undefined` atau `Uncaught TypeError`).
- [ ] **Responsivitas**: Tampilan diuji dan rapi pada resolusi Desktop (1440px), Laptop (1024px), Tablet (768px), dan Smartphone (375px).
- [ ] **Chatbot Fastbots**: Widget floating chatbot muncul di sudut kanan bawah layar sesuai Bot ID yang ditentukan.
