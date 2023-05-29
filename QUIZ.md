Tabel quizzes: Tabel ini akan menyimpan informasi umum tentang kuis.

id (primary key)
title (judul kuis)
description (deskripsi kuis)
created_at (timestamp untuk pencatatan waktu pembuatan)
updated_at (timestamp untuk pencatatan waktu pembaruan)
Tabel questions: Tabel ini akan menyimpan pertanyaan-pertanyaan dalam kuis.

id (primary key)
quiz_id (foreign key mengacu pada id kuis terkait)
question_text (teks pertanyaan)
question_type (tipe pertanyaan, misalnya 'multiple_choice' atau 'essay')
created_at (timestamp untuk pencatatan waktu pembuatan)
updated_at (timestamp untuk pencatatan waktu pembaruan)
Tabel options (opsional): Tabel ini hanya diperlukan jika Anda ingin menyimpan pilihan jawaban untuk pertanyaan pilihan ganda.

id (primary key)
question_id (foreign key mengacu pada id pertanyaan terkait)
option_text (teks pilihan jawaban)
is_correct (indikator apakah pilihan jawaban ini benar atau salah)
created_at (timestamp untuk pencatatan waktu pembuatan)
updated_at (timestamp untuk pencatatan waktu pembaruan)
Tabel answers: Tabel ini akan menyimpan jawaban-jawaban siswa untuk pertanyaan-pertanyaan kuis.

id (primary key)
question_id (foreign key mengacu pada id pertanyaan terkait)
user_id (foreign key mengacu pada id pengguna yang menjawab)
answer_text (teks jawaban untuk pertanyaan esai, atau ID pilihan jawaban untuk pertanyaan pilihan ganda)
created_at (timestamp untuk pencatatan waktu pembuatan)
updated_at (timestamp untuk pencatatan waktu pembaruan)