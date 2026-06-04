import 'package:flutter/material.dart';

class TaskHistoryDetailPage extends StatelessWidget {
  final Map<String, dynamic> item;

  const TaskHistoryDetailPage({super.key, required this.item});

  @override
  Widget build(BuildContext context) {
    final nilai = int.tryParse(item['nilai'].toString()) ?? 0;

    Color nilaiColor = nilai >= 80
        ? Colors.green
        : nilai >= 60
        ? Colors.orange
        : Colors.red;

    return Scaffold(
      backgroundColor: const Color(0xFFF5F1DD),

      body: Column(
        children: [
          // HEADER
          Container(
            width: double.infinity,
            height: 170,
            decoration: const BoxDecoration(
              color: Color(0xFFAFC2F2),
              borderRadius: BorderRadius.only(bottomRight: Radius.circular(80)),
              boxShadow: [
                BoxShadow(
                  color: Colors.black26,
                  blurRadius: 5,
                  offset: Offset(0, 3),
                ),
              ],
            ),
            child: SafeArea(
              child: Padding(
                padding: const EdgeInsets.fromLTRB(22, 20, 22, 18),
                child: Row(
                  children: [
                    GestureDetector(
                      onTap: () {
                        Navigator.pop(context);
                      },
                      child: Container(
                        width: 32,
                        height: 32,
                        decoration: BoxDecoration(
                          shape: BoxShape.circle,
                          border: Border.all(color: Colors.black),
                        ),
                        child: const Icon(
                          Icons.arrow_back,
                          size: 18,
                          color: Colors.black,
                        ),
                      ),
                    ),

                    const SizedBox(width: 15),

                    const Expanded(
                      child: Text(
                        'Detail Tugas',
                        style: TextStyle(
                          fontSize: 22,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                    ),

                    const Icon(
                      Icons.menu_book_rounded,
                      size: 55,
                      color: Color(0xFF2E2ED8),
                    ),
                  ],
                ),
              ),
            ),
          ),

          Expanded(
            child: SingleChildScrollView(
              padding: const EdgeInsets.all(22),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    item['judul'] ?? '-',
                    style: const TextStyle(
                      fontSize: 26,
                      fontWeight: FontWeight.bold,
                    ),
                  ),

                  const SizedBox(height: 5),

                  Text(
                    item['kategori'] ?? '-',
                    style: const TextStyle(fontSize: 16, color: Colors.black54),
                  ),

                  const SizedBox(height: 25),

                  // NILAI
                  Center(
                    child: Container(
                      width: 120,
                      height: 120,
                      decoration: BoxDecoration(
                        color: nilaiColor,
                        shape: BoxShape.circle,
                        boxShadow: [
                          BoxShadow(color: Colors.black26, blurRadius: 8),
                        ],
                      ),
                      child: Center(
                        child: Text(
                          nilai.toString(),
                          style: const TextStyle(
                            color: Colors.white,
                            fontSize: 36,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                      ),
                    ),
                  ),

                  const SizedBox(height: 25),

                  Container(
                    width: double.infinity,
                    padding: const EdgeInsets.all(18),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(18),
                      boxShadow: [
                        BoxShadow(color: Colors.black12, blurRadius: 5),
                      ],
                    ),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        const Text(
                          'Tanggal',
                          style: TextStyle(fontWeight: FontWeight.bold),
                        ),

                        const SizedBox(height: 8),

                        Text(item['submitted_at']?.toString() ?? '-'),

                        const SizedBox(height: 20),

                        const Text(
                          'Soal',
                          style: TextStyle(fontWeight: FontWeight.bold),
                        ),

                        const SizedBox(height: 8),

                        Text(item['soal'] ?? '-'),

                        const SizedBox(height: 20),

                        const Text(
                          'Jawaban OCR',
                          style: TextStyle(fontWeight: FontWeight.bold),
                        ),

                        const SizedBox(height: 8),

                        Text(item['jawaban_ocr'] ?? '-'),
                      ],
                    ),
                  ),

                  const SizedBox(height: 20),

                  if (item['photo_path'] != null &&
                      item['photo_path'].toString().isNotEmpty)
                    Container(
                      width: double.infinity,
                      padding: const EdgeInsets.all(12),
                      decoration: BoxDecoration(
                        color: Colors.white,
                        borderRadius: BorderRadius.circular(18),
                      ),
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          const Text(
                            'Foto Jawaban',
                            style: TextStyle(fontWeight: FontWeight.bold),
                          ),

                          const SizedBox(height: 15),

                          ClipRRect(
                            borderRadius: BorderRadius.circular(16),
                            child: Image.network(
                              'http://192.168.0.15:8000/storage/${item['photo_path']}',
                              height: 250,
                              width: double.infinity,
                              fit: BoxFit.cover,

                              loadingBuilder:
                                  (context, child, loadingProgress) {
                                    if (loadingProgress == null) {
                                      return child;
                                    }

                                    return const SizedBox(
                                      height: 250,
                                      child: Center(
                                        child: CircularProgressIndicator(),
                                      ),
                                    );
                                  },

                              errorBuilder: (context, error, stackTrace) {
                                print('ERROR FOTO = $error');

                                print(
                                  'URL FOTO = http://192.168.0.15:8000/storage/${item['photo_path']}',
                                );

                                return Container(
                                  height: 250,
                                  alignment: Alignment.center,
                                  child: Text(
                                    'Gagal memuat foto\n\n'
                                    'http://192.168.0.15:8000/storage/${item['photo_path']}',
                                    textAlign: TextAlign.center,
                                  ),
                                );
                              },
                            ),
                          ),
                        ],
                      ),
                    ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}
