<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa Validasi
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut berisi pesan kesalahan default yang digunakan oleh
    | kelas validator. Beberapa aturan memiliki beberapa versi seperti aturan
    | ukuran. Silakan sesuaikan pesan ini sesuai kebutuhan Anda.
    |
    */

    'accepted' => 'Kolom :attribute harus diterima.',
    'accepted_if' => 'Kolom :attribute harus diterima ketika :other adalah :value.',
    'active_url' => 'Kolom :attribute harus berupa URL yang valid.',
    'after' => 'Kolom :attribute harus berupa tanggal setelah :date.',
    'after_or_equal' => 'Kolom :attribute harus berupa tanggal setelah atau sama dengan :date.',
    'alpha' => 'Kolom :attribute hanya boleh berisi huruf.',
    'alpha_dash' => 'Kolom :attribute hanya boleh berisi huruf, angka, strip, dan garis bawah.',
    'alpha_num' => 'Kolom :attribute hanya boleh berisi huruf dan angka.',
    'any_of' => 'Kolom :attribute tidak valid.',
    'array' => 'Kolom :attribute harus berupa array.',
    'ascii' => 'Kolom :attribute hanya boleh berisi karakter alfanumerik satu byte dan simbol.',
    'before' => 'Kolom :attribute harus berupa tanggal sebelum :date.',
    'before_or_equal' => 'Kolom :attribute harus berupa tanggal sebelum atau sama dengan :date.',
    'between' => [
        'array' => 'Kolom :attribute harus memiliki antara :min sampai :max item.',
        'file' => 'Kolom :attribute harus antara :min sampai :max kilobyte.',
        'numeric' => 'Kolom :attribute harus antara :min sampai :max.',
        'string' => 'Kolom :attribute harus antara :min sampai :max karakter.',
    ],
    'boolean' => 'Kolom :attribute harus bernilai true atau false.',
    'can' => 'Kolom :attribute berisi nilai yang tidak diizinkan.',
    'confirmed' => 'Konfirmasi kolom :attribute tidak cocok.',
    'contains' => 'Kolom :attribute tidak memiliki nilai yang diperlukan.',
    'current_password' => 'Kata sandi salah.',
    'date' => 'Kolom :attribute harus berupa tanggal yang valid.',
    'date_equals' => 'Kolom :attribute harus berupa tanggal yang sama dengan :date.',
    'date_format' => 'Kolom :attribute harus sesuai dengan format :format.',
    'decimal' => 'Kolom :attribute harus memiliki :decimal angka desimal.',
    'declined' => 'Kolom :attribute harus ditolak.',
    'declined_if' => 'Kolom :attribute harus ditolak ketika :other adalah :value.',
    'different' => 'Kolom :attribute dan :other harus berbeda.',
    'digits' => 'Kolom :attribute harus terdiri dari :digits digit.',
    'digits_between' => 'Kolom :attribute harus antara :min sampai :max digit.',
    'dimensions' => 'Kolom :attribute memiliki dimensi gambar yang tidak valid.',
    'distinct' => 'Kolom :attribute memiliki nilai duplikat.',
    'doesnt_contain' => 'Kolom :attribute tidak boleh mengandung salah satu dari: :values.',
    'doesnt_end_with' => 'Kolom :attribute tidak boleh diakhiri dengan salah satu dari: :values.',
    'doesnt_start_with' => 'Kolom :attribute tidak boleh diawali dengan salah satu dari: :values.',
    'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
    'encoding' => 'Kolom :attribute harus menggunakan encoding :encoding.',
    'ends_with' => 'Kolom :attribute harus diakhiri dengan salah satu dari: :values.',
    'enum' => 'Pilihan :attribute tidak valid.',
    'exists' => 'Pilihan :attribute tidak valid.',
    'extensions' => 'Kolom :attribute harus memiliki salah satu ekstensi berikut: :values.',
    'file' => 'Kolom :attribute harus berupa berkas.',
    'filled' => 'Kolom :attribute harus memiliki nilai.',
    'gt' => [
        'array' => 'Kolom :attribute harus memiliki lebih dari :value item.',
        'file' => 'Kolom :attribute harus lebih dari :value kilobyte.',
        'numeric' => 'Kolom :attribute harus lebih dari :value.',
        'string' => 'Kolom :attribute harus lebih dari :value karakter.',
    ],
    'gte' => [
        'array' => 'Kolom :attribute harus memiliki :value item atau lebih.',
        'file' => 'Kolom :attribute harus lebih besar atau sama dengan :value kilobyte.',
        'numeric' => 'Kolom :attribute harus lebih besar atau sama dengan :value.',
        'string' => 'Kolom :attribute harus lebih besar atau sama dengan :value karakter.',
    ],
    'hex_color' => 'Kolom :attribute harus berupa warna heksadesimal yang valid.',
    'image' => 'Kolom :attribute harus berupa gambar.',
    'in' => 'Pilihan :attribute tidak valid.',
    'in_array' => 'Kolom :attribute harus ada di :other.',
    'in_array_keys' => 'Kolom :attribute harus memuat minimal salah satu kunci berikut: :values.',
    'integer' => 'Kolom :attribute harus berupa bilangan bulat.',
    'ip' => 'Kolom :attribute harus berupa alamat IP yang valid.',
    'ipv4' => 'Kolom :attribute harus berupa alamat IPv4 yang valid.',
    'ipv6' => 'Kolom :attribute harus berupa alamat IPv6 yang valid.',
    'json' => 'Kolom :attribute harus berupa string JSON yang valid.',
    'list' => 'Kolom :attribute harus berupa daftar.',
    'lowercase' => 'Kolom :attribute harus berupa huruf kecil.',
    'lt' => [
        'array' => 'Kolom :attribute harus memiliki kurang dari :value item.',
        'file' => 'Kolom :attribute harus kurang dari :value kilobyte.',
        'numeric' => 'Kolom :attribute harus kurang dari :value.',
        'string' => 'Kolom :attribute harus kurang dari :value karakter.',
    ],
    'lte' => [
        'array' => 'Kolom :attribute tidak boleh lebih dari :value item.',
        'file' => 'Kolom :attribute harus kurang dari atau sama dengan :value kilobyte.',
        'numeric' => 'Kolom :attribute harus kurang dari atau sama dengan :value.',
        'string' => 'Kolom :attribute harus kurang dari atau sama dengan :value karakter.',
    ],
    'mac_address' => 'Kolom :attribute harus berupa alamat MAC yang valid.',
    'max' => [
        'array' => 'Kolom :attribute tidak boleh lebih dari :max item.',
        'file' => 'Kolom :attribute tidak boleh lebih dari :max kilobyte.',
        'numeric' => 'Kolom :attribute tidak boleh lebih dari :max.',
        'string' => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
    ],
    'max_digits' => 'Kolom :attribute tidak boleh lebih dari :max digit.',
    'mimes' => 'Kolom :attribute harus berupa berkas berjenis: :values.',
    'mimetypes' => 'Kolom :attribute harus berupa berkas berjenis: :values.',
    'min' => [
        'array' => 'Kolom :attribute harus memiliki minimal :min item.',
        'file' => 'Kolom :attribute harus minimal :min kilobyte.',
        'numeric' => 'Kolom :attribute harus minimal :min.',
        'string' => 'Kolom :attribute harus minimal :min karakter.',
    ],
    'min_digits' => 'Kolom :attribute harus memiliki minimal :min digit.',
    'missing' => 'Kolom :attribute harus tidak ada.',
    'missing_if' => 'Kolom :attribute harus tidak ada ketika :other adalah :value.',
    'missing_unless' => 'Kolom :attribute harus tidak ada kecuali :other bernilai :value.',
    'missing_with' => 'Kolom :attribute harus tidak ada ketika :values ada.',
    'missing_with_all' => 'Kolom :attribute harus tidak ada ketika :values ada.',
    'multiple_of' => 'Kolom :attribute harus kelipatan dari :value.',
    'not_in' => 'Pilihan :attribute tidak valid.',
    'not_regex' => 'Format kolom :attribute tidak valid.',
    'numeric' => 'Kolom :attribute harus berupa angka.',
    'password' => [
        'letters' => 'Kolom :attribute harus mengandung setidaknya satu huruf.',
        'mixed' => 'Kolom :attribute harus mengandung setidaknya satu huruf kapital dan satu huruf kecil.',
        'numbers' => 'Kolom :attribute harus mengandung setidaknya satu angka.',
        'symbols' => 'Kolom :attribute harus mengandung setidaknya satu simbol.',
        'uncompromised' => ':attribute yang diberikan ditemukan dalam kebocoran data. Silakan pilih :attribute lain.',
    ],
    'present' => 'Kolom :attribute harus ada.',
    'present_if' => 'Kolom :attribute harus ada ketika :other adalah :value.',
    'present_unless' => 'Kolom :attribute harus ada kecuali :other bernilai :value.',
    'present_with' => 'Kolom :attribute harus ada ketika :values ada.',
    'present_with_all' => 'Kolom :attribute harus ada ketika :values ada.',
    'prohibited' => 'Kolom :attribute dilarang diisi.',
    'prohibited_if' => 'Kolom :attribute dilarang diisi ketika :other adalah :value.',
    'prohibited_if_accepted' => 'Kolom :attribute dilarang diisi ketika :other diterima.',
    'prohibited_if_declined' => 'Kolom :attribute dilarang diisi ketika :other ditolak.',
    'prohibited_unless' => 'Kolom :attribute dilarang diisi kecuali :other ada dalam :values.',
    'prohibits' => 'Kolom :attribute melarang :other untuk ada.',
    'regex' => 'Format kolom :attribute tidak valid.',
    'required' => 'Kolom :attribute wajib diisi.',
    'required_array_keys' => 'Kolom :attribute harus berisi entri untuk: :values.',
    'required_if' => 'Kolom :attribute wajib diisi ketika :other bernilai :value.',
    'required_if_accepted' => 'Kolom :attribute wajib diisi ketika :other diterima.',
    'required_if_declined' => 'Kolom :attribute wajib diisi ketika :other ditolak.',
    'required_unless' => 'Kolom :attribute wajib diisi kecuali :other ada dalam :values.',
    'required_with' => 'Kolom :attribute wajib diisi ketika :values tersedia.',
    'required_with_all' => 'Kolom :attribute wajib diisi ketika :values tersedia.',
    'required_without' => 'Kolom :attribute wajib diisi ketika :values tidak tersedia.',
    'required_without_all' => 'Kolom :attribute wajib diisi ketika tidak ada satupun dari :values tersedia.',
    'same' => 'Kolom :attribute dan :other harus sama.',
    'size' => [
        'array' => 'Kolom :attribute harus berisi :size item.',
        'file' => 'Kolom :attribute harus berukuran :size kilobyte.',
        'numeric' => 'Kolom :attribute harus berukuran :size.',
        'string' => 'Kolom :attribute harus berukuran :size karakter.',
    ],
    'starts_with' => 'Kolom :attribute harus dimulai dengan salah satu dari: :values.',
    'string' => 'Kolom :attribute harus berupa string.',
    'timezone' => 'Kolom :attribute harus berupa zona waktu yang valid.',
    'unique' => ':attribute sudah digunakan.',
    'uploaded' => 'Gagal mengunggah :attribute.',
    'uppercase' => 'Kolom :attribute harus huruf besar.',
    'url' => 'Kolom :attribute harus berupa URL yang valid.',
    'ulid' => 'Kolom :attribute harus berupa ULID yang valid.',
    'uuid' => 'Kolom :attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa Kustom untuk Validasi
    |--------------------------------------------------------------------------
    |
    | Di sini Anda dapat menentukan pesan validasi kustom untuk atribut
    | menggunakan konvensi "attribute.rule" untuk menamai baris bahasa.
    | Hal ini membuatnya cepat untuk menentukan baris bahasa khusus
    | untuk aturan atribut tertentu.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'pesan-khusus',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Atribut Validasi Kustom
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut digunakan untuk mengganti placeholder atribut kita
    | dengan sesuatu yang lebih ramah pembaca seperti "Alamat Email" daripada
    | "email". Hal ini hanya membantu kita membuat pesan lebih ekspresif.
    |
    */

    'attributes' => [],

];
