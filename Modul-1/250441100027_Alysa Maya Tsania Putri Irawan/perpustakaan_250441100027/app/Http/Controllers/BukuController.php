<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BukuController extends Controller
{
    private function getDataBuku()
    {
        return [
            [
                'id' => 1,
                'judul' => 'Eliana',
                'penulis' => 'Tere Liye',
                'tahun_terbit' => '2011',
                'kategori' => 'Fiksi & Petualangan',
                'deskripsi' => 'Kisah tentang Eliana si anak pemberani yang membela lingkungan dan tempat tinggalnya dari kerusakan tambang liar di lembah tempat tinggal mereka.',
                'gambar' => asset('images/eliana.jpg'),
            ],
            [
                'id' => 2,
                'judul' => 'Laskar Pelangi',
                'penulis' => 'Andrea Hirata',
                'tahun_terbit' => '2005',
                'kategori' => 'Inspiratif & Pendidikan',
                'deskripsi' => 'Perjuangan 10 anak dari keluarga miskin di Belitung dalam menempuh pendidikan di sekolah Muhammadiyah yang penuh keterbatasan.',
                'gambar' => asset('images/laskar pelangi.jpg'),
            ],
            [
                'id' => 3,
                'judul' => 'Bumi',
                'penulis' => 'Tere Liye',
                'tahun_terbit' => '2014',
                'kategori' => 'Serial Dunia Paralel',
                'deskripsi' => 'Petualangan fantastis tiga remaja, Raib, Seli, dan Ali, yang menjelajahi dunia paralel dengan kemampuan ajaib yang mereka miliki.',
                'gambar' => asset('images/bumi.jpg'),
            ],
            [
                'id' => 4,
                'judul' => 'Cantik Itu Luka',
                'penulis' => 'Eka Kurniawan',
                'tahun_terbit' => '2002',
                'kategori' => 'Sastra & Sejarah',
                'deskripsi' => 'Kisah epik berlatar sejarah Indonesia yang memadukan realisme magis, satire sosial, dan sejarah perjuangan bangsa.',
                'gambar' => asset('images/Cantik itu luka.jpg'),
            ],
            [
                'id' => 5,
                'judul' => 'Perahu Kertas',
                'penulis' => 'Dee Lestari',
                'tahun_terbit' => '2009',
                'kategori' => 'Romansa & Drama',
                'deskripsi' => 'Perjalanan cinta dan pencarian jati diri antara Kugy, sang pemimpi yang suka menulis dongeng, dan Keenan, pemuda berbakat seni melukis.',
                'gambar' => asset('images/Perahu kertas.jpg'),
            ],
            [
                'id' => 6,
                'judul' => 'Bumi Manusia',
                'penulis' => 'Pramoedya Ananta',
                'tahun_terbit' => '1980',
                'kategori' => 'Sastra Klasik',
                'deskripsi' => 'Perjuangan Minke, seorang pemuda pribumi terpelajar, di tengah diskriminasi dan pergolakan sosial pada masa kolonial Hindia Belanda.',
                'gambar' => asset('images/bumi manusia.jpg')
            ],
            [
                'id' => 7,
                'judul' => 'Negeri 5 Menara',
                'penulis' => 'Ahmad Fuadi',
                'tahun_terbit' => '2009',
                'kategori' => 'Inspiratif & Pembelajaran',
                'deskripsi' => 'Kisah enam santri dari berbagai daerah di Pesantren Madani yang memegang teguh mantra "Man Jadda Wajada" untuk meraih impian mereka.',
                'gambar' => asset('images/negeri 5 menara.jpg')
            ],
            [
                'id' => 8,
                'judul' => 'Pukat',
                'penulis' => 'Tere Liye',
                'tahun_terbit' => '2010',
                'kategori' => 'Fiksi & Petualangan',
                'deskripsi' => 'Sebuah kumpulan kisah fiksi yang hangat dan menyentuh tentang perjuangan hidup, penerimaan diri, serta harapan-harapan sederhana di tengah pergumulan batin.',
                'gambar' => asset('images/pukat.jpg')
            ],
        ];
    }

    public function index(Request $request)
    {
        $buku = $this->getDataBuku();
        $keyword = $request->query('search');

        if ($keyword) {
            $buku = collect($buku)->filter(function ($item) use ($keyword) {
                return stripos($item['judul'], $keyword) !== false ||
                       stripos($item['penulis'], $keyword) !== false ||
                       stripos($item['kategori'], $keyword) !== false;
            })->all();
        }

        return view('buku.index', compact('buku', 'keyword'));
    }

    public function show($id)
    {
        $allBuku = $this->getDataBuku();
        $buku = collect($allBuku)->firstWhere('id', (int) $id);

        return view('buku.show', compact('buku'));
    }
}