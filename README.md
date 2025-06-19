# PHP Email HTML Template Library

[![License](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

Library PHP untuk mengirim email dengan dukungan template HTML menggunakan PHPMailer dan Twig. Library ini memudahkan pengiriman email dengan tampilan profesional menggunakan template HTML yang dapat disesuaikan.

## Daftar Isi

- [Fitur](#fitur)
- [Persyaratan](#persyaratan)
- [Instalasi](#instalasi)
- [Konfigurasi](#konfigurasi)
- [Penggunaan Dasar](#penggunaan-dasar)
- [Template Email](#template-email)
- [Mengirim Email dengan Attachment](#mengirim-email-dengan-attachment)
- [API Referensi](#api-referensi)
- [Kontribusi](#kontribusi)
- [Lisensi](#lisensi)

## Fitur

- Integrasi dengan PHPMailer untuk pengiriman email yang handal
- Dukungan template HTML menggunakan Twig
- Konfigurasi SMTP yang fleksibel
- Kemampuan untuk mengirim email dengan file attachment dan string attachment
- Dukungan untuk CC dan BCC
- Metode fluent interface untuk kemudahan penggunaan

## Persyaratan

- PHP 7.4 atau lebih tinggi
- Composer

## Instalasi

Instalasi library ini dapat dilakukan dengan mudah menggunakan Composer:

```bash
composer require ay4t/php-mailer-template
```

## Konfigurasi

Sebelum menggunakan library, Anda perlu mengatur konfigurasi SMTP. Anda dapat melakukannya dengan membuat instance konfigurasi sendiri atau menggunakan konfigurasi default.

### Menggunakan Konfigurasi Default

Konfigurasi default tersedia di `src/Config/App.php`. Anda perlu mengubah nilai-nilai berikut sesuai dengan pengaturan SMTP Anda:

```php
// Buat file konfigurasi kustom yang meng-extend konfigurasi default
class MyConfig extends \Ay4t\Emailhtml\Config\App 
{
    public function __construct()
    {
        $this->Host = 'smtp.gmail.com';            // Server SMTP
        $this->Username = 'your-email@gmail.com';   // Username SMTP
        $this->Password = 'your-password';          // Password SMTP
        $this->Port = 465;                          // Port SMTP
        $this->FromName = 'Your Name';              // Nama pengirim
        $this->FromEmail = 'your-email@gmail.com';  // Email pengirim
        $this->template_path = '/path/to/templates'; // Path template kustom (opsional)
    }
}

// Gunakan konfigurasi kustom
$email = new \Ay4t\Emailhtml\Mailer('template_name', new MyConfig());
```

## Penggunaan Dasar

Berikut adalah contoh penggunaan dasar untuk mengirim email:

```php
// Inisialisasi mailer dengan template default
$email = new \Ay4t\Emailhtml\Mailer();

// Tambahkan data untuk template
$email->mergeData([
    'fullname'      => 'John Doe',
    'dashboard_url' => 'https://example.com/dashboard',
    'username'      => 'johndoe',
    'password'      => '123456',
]);

// Atur subjek email
$email->setSubject('Selamat Datang di Aplikasi Kami');

// Atur teks alternatif untuk klien email yang tidak mendukung HTML
$email->setAltBody('Selamat datang di aplikasi kami. Username: johndoe, Password: 123456');

// Tambahkan penerima
$email->sendTo('recipient@example.com', 'Recipient Name');

// Tambahkan CC (opsional)
$email->addCCto('cc@example.com', 'CC Recipient');

// Nonaktifkan output debug (opsional)
$email->setDebugOutput(false);

// Kirim email
$result = $email->send();

if ($result) {
    echo "Email berhasil dikirim!";
} else {
    echo "Gagal mengirim email.";
}
```

## Template Email

Library ini mendukung penggunaan template HTML dengan Twig. Template default tersedia di direktori `src/Templates/default/`.

### Menggunakan Template Kustom

```php
// Inisialisasi mailer dengan template kustom
$email = new \Ay4t\Emailhtml\Mailer('account_welcome');

// Tambahkan data untuk template
$email->mergeData([
    'fullname'      => 'John Doe',
    'dashboard_url' => 'https://example.com/dashboard',
    'username'      => 'johndoe',
    'password'      => '123456',
]);

// Lanjutkan dengan pengaturan lainnya seperti pada contoh dasar
$email->setSubject('Selamat Datang di Aplikasi Kami');
$email->sendTo('recipient@example.com', 'Recipient Name');
$email->send();
```

## Mengirim Email dengan Attachment

Library ini mendukung pengiriman email dengan attachment. Terdapat dua jenis attachment yang didukung: file attachment dan string attachment.

### File Attachment

File attachment menggunakan path file di sistem untuk melampirkan file ke email.

#### Menambahkan File Attachment Tunggal

```php
$email = new \Ay4t\Emailhtml\Mailer();

// Tambahkan attachment tunggal
$email->addAttachment([
    'name' => 'Surat Penawaran.pdf',
    'content' => '/path/to/surat-penawaran.pdf'
]);

// Lanjutkan dengan pengaturan email lainnya
$email->setSubject('Penawaran Produk');
$email->sendTo('client@example.com', 'Client Name');
$email->send();
```

#### Menambahkan Multiple File Attachment

```php
$email = new \Ay4t\Emailhtml\Mailer();

// Tambahkan multiple attachment sekaligus
$email->addMultiAttachments([
    [
        'name' => 'Surat Penawaran.pdf',
        'content' => '/path/to/surat-penawaran.pdf'
    ],
    [
        'name' => 'Invoice.pdf',
        'content' => '/path/to/invoice.pdf'
    ]
]);

// Atau tambahkan attachment satu per satu
$email->addAttachment([
    'name' => 'Katalog Produk.pdf',
    'content' => '/path/to/katalog.pdf'
]);

// Lanjutkan dengan pengaturan email lainnya
$email->setSubject('Penawaran dan Invoice');
$email->sendTo('client@example.com', 'Client Name');
$email->send();
```

### String Attachment

String attachment memungkinkan Anda melampirkan data langsung (string atau binary) ke email tanpa perlu file fisik. Ini sangat berguna untuk melampirkan data dari database atau konten yang dihasilkan secara dinamis.

#### Menambahkan String Attachment Tunggal

```php
$email = new \Ay4t\Emailhtml\Mailer();

// Contoh data string (misalnya dari database atau hasil generate PDF)
$pdfContent = generatePdfContent(); // Fungsi contoh yang menghasilkan konten PDF

// Tambahkan string attachment
$email->addStringAttachment(
    $pdfContent,
    'laporan-bulanan.pdf',
    null, // encoding (default: base64)
    'application/pdf', // MIME type
    'attachment' // disposition
);

// Lanjutkan dengan pengaturan email lainnya
$email->setSubject('Laporan Bulanan');
$email->sendTo('manager@example.com', 'Manager Name');
$email->send();
```

#### Menambahkan Multiple String Attachment

```php
$email = new \Ay4t\Emailhtml\Mailer();

// Contoh data untuk multiple attachment
$pdfContent = generatePdfContent();
$excelContent = generateExcelContent();

// Tambahkan multiple string attachment sekaligus
$email->addMultiStringAttachments([
    [
        'string' => $pdfContent,
        'filename' => 'laporan-bulanan.pdf',
        'type' => 'application/pdf'
    ],
    [
        'string' => $excelContent,
        'filename' => 'data-penjualan.xlsx',
        'type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ]
]);

// Lanjutkan dengan pengaturan email lainnya
$email->setSubject('Laporan dan Data Penjualan');
$email->sendTo('manager@example.com', 'Manager Name');
$email->send();
```

## API Referensi

### Kelas Mailer

#### Konstruktor

```php
__construct($filename = 'account_welcome', $config = null)
```

- `$filename`: Nama file template (tanpa ekstensi .html)
- `$config`: Objek konfigurasi kustom (opsional)

#### Metode

| Metode | Deskripsi |
|--------|------------|
| `mergeData(array $var)` | Menggabungkan data untuk template |
| `render($shared = false)` | Render template HTML |
| `sendTo(string $to_email, string $to_name)` | Menambahkan penerima email |
| `addCCto(string $cc_email, string $cc_name)` | Menambahkan penerima CC |
| `setSubject(string $sendSubject)` | Mengatur subjek email |
| `setAltBody(string $altBody)` | Mengatur teks alternatif untuk klien email non-HTML |
| `setDebugOutput($debugOutput)` | Mengaktifkan/menonaktifkan output debug |
| `addAttachment(array $attachment)` | Menambahkan file attachment tunggal |
| `addMultiAttachments(array $attachments)` | Menambahkan multiple file attachment |
| `addStringAttachment($string, $filename, $encoding, $type, $disposition)` | Menambahkan string attachment (data langsung) |
| `addMultiStringAttachments(array $attachments)` | Menambahkan multiple string attachment |
| `send()` | Mengirim email |

## Kontribusi

Kontribusi untuk pengembangan library ini sangat diterima. Silakan fork repositori ini, buat perubahan, dan kirimkan pull request.

## Lisensi

Library ini dilisensikan di bawah [MIT License](LICENSE).
