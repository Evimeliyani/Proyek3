import 'package:flutter/material.dart';

import '../../services/task_service.dart';
import 'task_ocr_page.dart';

class QuizListPage extends StatefulWidget {
  final String categoryTitle;

  const QuizListPage({
    super.key,
    required this.categoryTitle,
  });

  @override
  State<QuizListPage> createState() =>
      _QuizListPageState();
}

class _QuizListPageState
    extends State<QuizListPage> {

  // =========================
  // WARNA KATEGORI
  // =========================

  Color getMainColor() {

    switch (
        widget.categoryTitle
            .toLowerCase()) {

      case 'penjumlahan':
        return const Color(0xFFFFD9E2);

      case 'pengurangan':
        return const Color(0xFFDDF6D7);

      case 'perkalian':
        return const Color(0xFFE9DDFF);

      case 'pembagian':
        return const Color(0xFFFFE9D9);

      default:
        return Colors.white;
    }
  }

  IconData getIcon() {

    switch (
        widget.categoryTitle
            .toLowerCase()) {

      case 'penjumlahan':
        return Icons.add_rounded;

      case 'pengurangan':
        return Icons.remove_rounded;

      case 'perkalian':
        return Icons.close_rounded;

      case 'pembagian':
        return Icons.horizontal_rule_rounded;

      default:
        return Icons.quiz_rounded;
    }
  }

  @override
  Widget build(BuildContext context) {

    final mainColor =
        getMainColor();

    return Scaffold(

      backgroundColor:
          const Color(0xFFFFFBEF),

      body: SafeArea(

        child: Column(

          children: [

            // =========================
            // HEADER
            // =========================

            Container(

              width: double.infinity,

              padding:
                  const EdgeInsets.only(
                left: 24,
                right: 24,
                top: 28,
                bottom: 30,
              ),

              decoration:
                  const BoxDecoration(

                color:
                    Color(0xFFC8D3FF),

                borderRadius:
                    BorderRadius.only(

                  bottomLeft:
                      Radius.circular(
                    42,
                  ),

                  bottomRight:
                      Radius.circular(
                    42,
                  ),
                ),

                boxShadow: [

                  BoxShadow(
                    color: Colors.black12,
                    blurRadius: 12,
                    offset: Offset(0, 5),
                  ),
                ],
              ),

              child: Row(

                children: [

                  GestureDetector(

                    onTap: () {
                      Navigator.pop(
                          context);
                    },

                    child: Container(

                      width: 68,
                      height: 68,

                      decoration:
                          BoxDecoration(

                        color:
                            Colors.white,

                        borderRadius:
                            BorderRadius.circular(
                          22,
                        ),
                      ),

                      child: const Icon(
                        Icons.arrow_back_rounded,
                        size: 38,
                      ),
                    ),
                  ),

                  const SizedBox(width: 18),

                  Expanded(

                    child: Text(

                      widget.categoryTitle,

                      overflow:
                          TextOverflow
                              .ellipsis,

                      style:
                          const TextStyle(

                        fontSize: 34,

                        fontWeight:
                            FontWeight.w900,

                        color:
                            Colors.black87,
                      ),
                    ),
                  ),
                ],
              ),
            ),

            // =========================
            // LIST SOAL
            // =========================

            Expanded(

              child:
                  FutureBuilder<List<dynamic>>(

                future:
                    TaskService
                        .getTasksByKategori(
                  widget.categoryTitle,
                ),

                builder:
                    (context, snapshot) {

                  // =====================
                  // LOADING
                  // =====================

                  if (snapshot
                          .connectionState ==
                      ConnectionState
                          .waiting) {

                    return const Center(
                      child:
                          CircularProgressIndicator(),
                    );
                  }

                  // =====================
                  // ERROR
                  // =====================

                  if (snapshot
                      .hasError) {

                    return Center(

                      child: Padding(

                        padding:
                            const EdgeInsets
                                .all(20),

                        child: Text(

                          '❌ ${snapshot.error}',

                          textAlign:
                              TextAlign
                                  .center,

                          style:
                              const TextStyle(
                            fontSize: 18,
                          ),
                        ),
                      ),
                    );
                  }

                  final tasks =
                      snapshot.data ??
                          [];

                  // =====================
                  // EMPTY
                  // =====================

                  if (tasks.isEmpty) {

                    return const Center(

                      child: Text(

                        'Belum ada tugas 😊',

                        style: TextStyle(

                          fontSize: 24,

                          fontWeight:
                              FontWeight.bold,
                        ),
                      ),
                    );
                  }

                  return ListView.builder(

                    padding:
                        const EdgeInsets.all(
                      20,
                    ),

                    itemCount:
                        tasks.length,

                    itemBuilder:
                        (context, index) {

                      final task =
                          tasks[index];

                      return GestureDetector(

                        onTap: () {

                          Navigator.push(

                            context,

                            MaterialPageRoute(

                              builder: (_) =>
                                  TaskOcrPage(

                                judul:
                                    task[
                                        'judul'],

                                soal:
                                    task[
                                        'soal'],

                                jawaban:
                                    task[
                                            'kunci_jawaban']
                                        .toString(),

                                kategori:
                                    task[
                                        'kategori'],
                              ),
                            ),
                          );
                        },

                        child: Container(

                          margin:
                              const EdgeInsets.only(
                            bottom: 24,
                          ),

                          padding:
                              const EdgeInsets.all(
                            20,
                          ),

                          decoration:
                              BoxDecoration(

                            color:
                                mainColor,

                            borderRadius:
                                BorderRadius.circular(
                              34,
                            ),

                            boxShadow: [

                              BoxShadow(
                                color: Colors
                                    .black12,
                                blurRadius: 10,
                                offset:
                                    const Offset(
                                  0,
                                  5,
                                ),
                              ),
                            ],
                          ),

                          child: Row(

                            children: [

                              // =================
                              // ICON
                              // =================

                              Container(

                                width: 72,
                                height: 72,

                                decoration:
                                    BoxDecoration(

                                  color:
                                      Colors.white,

                                  borderRadius:
                                      BorderRadius.circular(
                                    22,
                                  ),
                                ),

                                child: Icon(

                                  getIcon(),

                                  size: 40,

                                  color:
                                      Colors.black87,
                                ),
                              ),

                              const SizedBox(
                                  width: 16),

                              // =================
                              // TEXT AREA
                              // =================

                              Expanded(

                                child: Column(

                                  crossAxisAlignment:
                                      CrossAxisAlignment
                                          .start,

                                  mainAxisAlignment:
                                      MainAxisAlignment
                                          .center,

                                  children: [

                                    // JUDUL
                                    Text(

                                      task[
                                          'judul'],

                                      maxLines: 2,

                                      overflow:
                                          TextOverflow
                                              .ellipsis,

                                      style:
                                          const TextStyle(

                                        fontSize:
                                            24,

                                        height:
                                            1.2,

                                        fontWeight:
                                            FontWeight
                                                .w900,

                                        color:
                                            Colors.black87,
                                      ),
                                    ),

                                    const SizedBox(
                                        height:
                                            10),

                                    // SOAL
                                    Container(

                                      padding:
                                          const EdgeInsets.symmetric(
                                        horizontal:
                                            14,
                                        vertical:
                                            7,
                                      ),

                                      decoration:
                                          BoxDecoration(

                                        color:
                                            Colors.white,

                                        borderRadius:
                                            BorderRadius.circular(
                                          16,
                                        ),
                                      ),

                                      child: Text(

                                        task[
                                            'soal'],

                                        maxLines:
                                            1,

                                        overflow:
                                            TextOverflow
                                                .ellipsis,

                                        style:
                                            const TextStyle(

                                          fontSize:
                                              17,

                                          fontWeight:
                                              FontWeight.bold,
                                        ),
                                      ),
                                    ),
                                  ],
                                ),
                              ),

                              const SizedBox(
                                  width: 14),

                              // =================
                              // BUTTON
                              // =================

                              Container(

                                width: 58,
                                height: 58,

                                decoration:
                                    BoxDecoration(

                                  color:
                                      Colors.white,

                                  borderRadius:
                                      BorderRadius.circular(
                                    18,
                                  ),
                                ),

                                child: const Icon(
                                  Icons
                                      .arrow_forward_ios_rounded,
                                  size: 24,
                                ),
                              ),
                            ],
                          ),
                        ),
                      );
                    },
                  );
                },
              ),
            ),
          ],
        ),
      ),
    );
  }
}