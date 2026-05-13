import 'dart:io';

import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import 'package:google_mlkit_text_recognition/google_mlkit_text_recognition.dart';

class TaskOcrPage extends StatefulWidget {

  final String judul;
  final String soal;
  final String jawaban;
  final String kategori;

  const TaskOcrPage({
    super.key,
    required this.judul,
    required this.soal,
    required this.jawaban,
    required this.kategori,
  });

  @override
  State<TaskOcrPage> createState() =>
      _TaskOcrPageState();
}

class _TaskOcrPageState
    extends State<TaskOcrPage> {

  File? imageFile;

  bool loading = false;

  String ocrText = '';

  bool isCorrect = false;

  final picker = ImagePicker();

  // =========================
  // OCR SCAN
  // =========================

  Future<void> scanImage() async {

    try {

      final picked =
          await picker.pickImage(
        source: ImageSource.camera,

        imageQuality: 70,

        maxWidth: 1000,
      );

      if (picked == null) return;

      setState(() {

        loading = true;

        imageFile = File(
          picked.path,
        );

        ocrText = '';

        isCorrect = false;
      });

      final inputImage =
          InputImage.fromFilePath(
        picked.path,
      );

      final textRecognizer =
          TextRecognizer();

      final recognizedText =
          await textRecognizer
              .processImage(
        inputImage,
      );

      String detected =
          recognizedText.text;

      // =====================
      // FILTER ANGKA SAJA
      // =====================

      detected = detected
          .replaceAll('O', '0')
          .replaceAll('o', '0')
          .replaceAll('S', '5')
          .replaceAll('s', '5');

      detected =
          detected.replaceAll(
        RegExp(r'[^0-9]'),
        '',
      );

      // =====================
      // VALIDASI OCR
      // =====================

      if (detected.isEmpty) {

        ScaffoldMessenger.of(context)
            .showSnackBar(

          const SnackBar(
            content: Text(
              'Jawaban tidak terbaca 😢\n'
              'Coba foto lebih dekat dan terang',
            ),
          ),
        );

        setState(() {
          loading = false;
        });

        return;
      }

      // =====================
      // VALIDASI JAWABAN
      // =====================

      bool correct =
          detected ==
          widget.jawaban;

      setState(() {

        ocrText = detected;

        isCorrect = correct;

        loading = false;
      });

      await textRecognizer.close();

    } catch (e) {

      setState(() {
        loading = false;
      });

      ScaffoldMessenger.of(context)
          .showSnackBar(

        SnackBar(
          content: Text(
            'OCR Error: $e',
          ),
        ),
      );
    }
  }

  // =========================
  // UI
  // =========================

  @override
  Widget build(BuildContext context) {

    return Scaffold(

      backgroundColor:
          const Color(0xFFFDF8E7),

      body: SafeArea(

        child: SingleChildScrollView(

          padding:
              const EdgeInsets.all(25),

          child: Column(

            crossAxisAlignment:
                CrossAxisAlignment.start,

            children: [

              // =====================
              // HEADER
              // =====================

              Row(
                children: [

                  GestureDetector(
                    onTap: () {
                      Navigator.pop(context);
                    },

                    child: const Icon(
                      Icons.arrow_back,
                      size: 40,
                    ),
                  ),

                  const SizedBox(width: 20),

                  Expanded(
                    child: Text(

                      widget.judul,

                      style: const TextStyle(
                        fontSize: 30,
                        fontWeight:
                            FontWeight.bold,
                      ),
                    ),
                  ),
                ],
              ),

              const SizedBox(height: 30),

              // =====================
              // SOAL
              // =====================

              Container(

                width: double.infinity,

                padding:
                    const EdgeInsets.all(
                  25,
                ),

                decoration: BoxDecoration(

                  color:
                      const Color(
                    0xFFFFF4D6,
                  ),

                  borderRadius:
                      BorderRadius.circular(
                    28,
                  ),
                ),

                child: Column(

                  crossAxisAlignment:
                      CrossAxisAlignment
                          .start,

                  children: [

                    const Text(

                      '📚 Soal',

                      style: TextStyle(

                        fontSize: 24,

                        fontWeight:
                            FontWeight.bold,
                      ),
                    ),

                    const SizedBox(
                        height: 18),

                    Center(
                      child: Text(

                        widget.soal,

                        style:
                            const TextStyle(

                          fontSize: 40,

                          fontWeight:
                              FontWeight.w900,
                        ),
                      ),
                    ),
                  ],
                ),
              ),

              const SizedBox(height: 25),

              // =====================
              // TIPS
              // =====================

              Container(

                width: double.infinity,

                padding:
                    const EdgeInsets.all(
                  22,
                ),

                decoration: BoxDecoration(

                  color:
                      const Color(
                    0xFFDCE5FF,
                  ),

                  borderRadius:
                      BorderRadius.circular(
                    28,
                  ),
                ),

                child: const Column(

                  crossAxisAlignment:
                      CrossAxisAlignment
                          .start,

                  children: [

                    Text(

                      '📸 Tips Foto',

                      style: TextStyle(

                        fontSize: 22,

                        fontWeight:
                            FontWeight.bold,
                      ),
                    ),

                    SizedBox(height: 16),

                    Text(
                      '• Gunakan tempat terang',
                      style:
                          TextStyle(fontSize: 18),
                    ),

                    SizedBox(height: 10),

                    Text(
                      '• Fokuskan kamera ke jawaban',
                      style:
                          TextStyle(fontSize: 18),
                    ),

                    SizedBox(height: 10),

                    Text(
                      '• Hindari blur',
                      style:
                          TextStyle(fontSize: 18),
                    ),

                    SizedBox(height: 10),

                    Text(
                      '• Tulis angka lebih besar',
                      style:
                          TextStyle(fontSize: 18),
                    ),
                  ],
                ),
              ),

              const SizedBox(height: 25),

              // =====================
              // BUTTON SCAN
              // =====================

              GestureDetector(

                onTap:
                    loading
                        ? null
                        : scanImage,

                child: Container(

                  width: double.infinity,

                  padding:
                      const EdgeInsets.all(
                    30,
                  ),

                  decoration: BoxDecoration(

                    color:
                        const Color(
                      0xFFF8D7DA,
                    ),

                    borderRadius:
                        BorderRadius.circular(
                      30,
                    ),

                    boxShadow: const [

                      BoxShadow(
                        color:
                            Colors.black12,

                        blurRadius: 10,

                        offset:
                            Offset(0, 5),
                      ),
                    ],
                  ),

                  child: Column(

                    children: [

                      loading

                          ? const CircularProgressIndicator()

                          : const Icon(
                              Icons
                                  .document_scanner,
                              size: 70,
                              color: Colors.red,
                            ),

                      const SizedBox(
                          height: 15),

                      Text(

                        loading
                            ? 'Memproses OCR...'
                            : '📸 Scan Jawaban',

                        style:
                            const TextStyle(

                          fontSize: 28,

                          fontWeight:
                              FontWeight.bold,
                        ),
                      ),
                    ],
                  ),
                ),
              ),

              const SizedBox(height: 25),

              // =====================
              // PREVIEW IMAGE
              // =====================

              if (imageFile != null)

                ClipRRect(

                  borderRadius:
                      BorderRadius.circular(
                    30,
                  ),

                  child: Image.file(
                    imageFile!,
                  ),
                ),

              const SizedBox(height: 25),

              // =====================
              // HASIL OCR
              // =====================

              Container(

                width: double.infinity,

                padding:
                    const EdgeInsets.all(
                  25,
                ),

                decoration: BoxDecoration(

                  color:
                      const Color(
                    0xFFDDE4FF,
                  ),

                  borderRadius:
                      BorderRadius.circular(
                    30,
                  ),
                ),

                child: Column(

                  crossAxisAlignment:
                      CrossAxisAlignment
                          .start,

                  children: [

                    const Text(

                      '✨ Jawaban Terdeteksi',

                      style: TextStyle(

                        fontSize: 28,

                        fontWeight:
                            FontWeight.bold,
                      ),
                    ),

                    const SizedBox(
                        height: 25),

                    Container(

                      width: double.infinity,

                      padding:
                          const EdgeInsets.all(
                        25,
                      ),

                      decoration:
                          BoxDecoration(

                        color: Colors.white,

                        borderRadius:
                            BorderRadius.circular(
                          25,
                        ),
                      ),

                      child: Column(

                        crossAxisAlignment:
                            CrossAxisAlignment
                                .start,

                        children: [

                          Row(
                            children: [

                              Icon(

                                isCorrect
                                    ? Icons
                                        .check_circle
                                    : Icons
                                        .cancel,

                                color:
                                    isCorrect
                                        ? Colors.green
                                        : Colors.red,

                                size: 50,
                              ),

                              const SizedBox(
                                  width: 15),

                              Expanded(
                                child: Text(

                                  ocrText
                                          .isEmpty
                                      ? 'Belum ada hasil OCR'
                                      : isCorrect
                                          ? 'Jawaban Benar 🎉'
                                          : 'Jawaban Belum Tepat 😢',

                                  style:
                                      TextStyle(

                                    fontSize:
                                        24,

                                    fontWeight:
                                        FontWeight.bold,

                                    color:
                                        isCorrect
                                            ? Colors.green
                                            : Colors.red,
                                  ),
                                ),
                              ),
                            ],
                          ),

                          const SizedBox(
                              height: 30),

                          Text(

                            'Hasil OCR: ${ocrText.isEmpty ? "???" : ocrText}',

                            style:
                                const TextStyle(

                              fontSize: 26,

                              fontWeight:
                                  FontWeight.bold,
                            ),
                          ),

                          const SizedBox(
                              height: 20),

                          Text(

                            'Kunci Jawaban: ${ocrText.isEmpty ? "???" : widget.jawaban}',

                            style:
                                const TextStyle(

                              fontSize: 24,

                              fontWeight:
                                  FontWeight.bold,
                            ),
                          ),
                        ],
                      ),
                    ),
                  ],
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}