<?php

namespace Database\Factories;

use App\Models\Kategori;
use App\Models\Buku;
use Illuminate\Database\Eloquent\Factories\Factory;

class BukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    private static int $i = 0;

    public function definition(): array
    {
    $daftar = [
        ['Eliana', 'Tere Liye', '2011', 'Fiksi & Petualangan',
         'Kisah tentang Eliana si anak pemberani yang membela lingkungan dan tempat tinggalnya dari kerusakan tambang liar di lembah tempat tinggal mereka.',
         'images/eliana.jpg'],
        ['Laskar Pelangi', 'Andrea Hirata', '2005', 'Inspiratif & Pendidikan',
         'Perjuangan 10 anak dari keluarga miskin di Belitung dalam menempuh pendidikan di sekolah Muhammadiyah yang penuh keterbatasan.',
         'images/laskar pelangi.jpg'],
        ['Bumi', 'Tere Liye', '2014', 'Serial Dunia Paralel',
         'Petualangan fantastis tiga remaja, Raib, Seli, dan Ali, yang menjelajahi dunia paralel dengan kemampuan ajaib yang mereka miliki.',
         'images/bumi.jpg'],
        ['Cantik Itu Luka', 'Eka Kurniawan', '2002', 'Sastra & Sejarah',
         'Kisah epik berlatar sejarah Indonesia yang memadukan realisme magis, satire sosial, dan sejarah perjuangan bangsa.',
         'images/Cantik itu luka.jpg'],
        ['Perahu Kertas', 'Dee Lestari', '2009', 'Romansa & Drama',
         'Perjalanan cinta dan pencarian jati diri antara Kugy, sang pemimpi yang suka menulis dongeng, dan Keenan, pemuda berbakat seni melukis.',
         'images/Perahu kertas.jpg'],
        ['Bumi Manusia', 'Pramoedya Ananta', '1980', 'Sastra Klasik',
         'Perjuangan Minke, seorang pemuda pribumi terpelajar, di tengah diskriminasi dan pergolakan sosial pada masa kolonial Hindia Belanda.',
         'images/bumi manusia.jpg'],
        ['Negeri 5 Menara', 'Ahmad Fuadi', '2009', 'Inspiratif & Pembelajaran',
         'Kisah enam santri dari berbagai daerah di Pesantren Madani yang memegang teguh mantra "Man Jadda Wajada" untuk meraih impian mereka.',
         'images/negeri 5 menara.jpg'],
        ['Pukat', 'Tere Liye', '2010', 'Fiksi & Petualangan',
         'Sebuah kumpulan kisah fiksi yang hangat dan menyentuh tentang perjuangan hidup, penerimaan diri, serta harapan-harapan sederhana di tengah pergumulan batin.',
         'images/pukat.jpg'],
    ];

    $b = $daftar[self::$i++ % count($daftar)];

    return [
        'kategori_id'  => Kategori::where('nama', $b[3])->value('id'),
        'judul'        => $b[0],
        'penulis'      => $b[1],
        'tahun_terbit' => $b[2],
        'deskripsi'    => $b[4],
        'gambar'       => $b[5],
    ];
    }
}
