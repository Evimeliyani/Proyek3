import 'package:flutter/material.dart';
import '../../services/question_services.dart';
import '../../services/quiz_result_service.dart';
import 'result_quiz_page.dart';

class DetailQuizPage extends StatefulWidget {
  final int quizId;
  final String title;

  const DetailQuizPage({
    super.key,
    required this.quizId,
    required this.title,
  });

  @override
  State<DetailQuizPage> createState() => _DetailQuizPageState();
}

class _DetailQuizPageState extends State<DetailQuizPage> {
  int currentIndex = 0;
  String? selectedOption;
  int correctCount = 0;
  bool alreadyAnswered = false;
  bool isSaving = false;

  Color buttonColor(String optionKey) {
    if (selectedOption == optionKey) {
      return const Color(0xFFBDE7BD);
    }
    return const Color(0xFFD9C6F0);
  }

  void _selectAnswer(Map<String, dynamic> question, String optionKey) {
    if (alreadyAnswered) return;

    setState(() {
      selectedOption = optionKey;
      alreadyAnswered = true;

      if ((question['correct_option'] ?? '').toString().toUpperCase() ==
          optionKey.toUpperCase()) {
        correctCount++;
      }
    });
  }

  Widget _answerButton(
    Map<String, dynamic> question,
    String label,
    String value,
    String optionKey,
  ) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 16),
      child: SizedBox(
        width: double.infinity,
        height: 56,
        child: ElevatedButton(
          style: ElevatedButton.styleFrom(
            backgroundColor: buttonColor(optionKey),
            foregroundColor: Colors.black,
            elevation: 4,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(28),
            ),
          ),
          onPressed: isSaving
              ? null
              : () {
                  _selectAnswer(question, optionKey);
                },
          child: Text(
            '$label. $value',
            style: const TextStyle(
              fontSize: 18,
              fontWeight: FontWeight.bold,
            ),
          ),
        ),
      ),
    );
  }

  int _calculateScore(int totalQuestions) {
    if (totalQuestions == 0) return 0;
    return ((correctCount / totalQuestions) * 100).round();
  }

  Future<void> _finishQuiz(List<dynamic> questions) async {
    final score = _calculateScore(questions.length);

    setState(() {
      isSaving = true;
    });

    try {
      await QuizResultService.saveResult(
        quizId: widget.quizId,
        score: score,
      );

      if (!mounted) return;

      Navigator.pushReplacement(
        context,
        MaterialPageRoute(
          builder: (_) => ResultQuizPage(score: score),
        ),
      );
    } catch (e) {
      if (!mounted) return;

      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Gagal simpan nilai: $e')),
      );
    } finally {
      if (mounted) {
        setState(() {
          isSaving = false;
        });
      }
    }
  }

  Future<void> _nextQuestion(List<dynamic> questions) async {
    if (!alreadyAnswered) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Pilih jawaban terlebih dahulu'),
        ),
      );
      return;
    }

    if (currentIndex < questions.length - 1) {
      setState(() {
        currentIndex++;
        selectedOption = null;
        alreadyAnswered = false;
      });
    } else {
      await _finishQuiz(questions);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF4F1DE),
      appBar: AppBar(
        backgroundColor: const Color(0xFFAFC2F2),
        title: Text(
          widget.title,
          style: const TextStyle(
            color: Colors.black,
            fontWeight: FontWeight.bold,
          ),
        ),
        iconTheme: const IconThemeData(color: Colors.black),
      ),
      body: FutureBuilder<List<dynamic>>(
        future: QuestionService.getQuestions(widget.quizId),
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(
              child: CircularProgressIndicator(),
            );
          }

          if (snapshot.hasError) {
            return Center(
              child: Text(
                'Error: ${snapshot.error}',
                textAlign: TextAlign.center,
              ),
            );
          }

          final questions = snapshot.data ?? [];

          if (questions.isEmpty) {
            return const Center(
              child: Text('Soal belum tersedia'),
            );
          }

          final q = questions[currentIndex] as Map<String, dynamic>;

          return Padding(
            padding: const EdgeInsets.all(20),
            child: Column(
              children: [
                Container(
                  width: double.infinity,
                  padding: const EdgeInsets.all(24),
                  decoration: BoxDecoration(
                    color: const Color(0xFFAFC2F2),
                    borderRadius: BorderRadius.circular(28),
                    boxShadow: const [
                      BoxShadow(
                        color: Colors.black12,
                        blurRadius: 6,
                        offset: Offset(0, 4),
                      ),
                    ],
                  ),
                  child: Column(
                    children: [
                      Text(
                        'Soal ${currentIndex + 1} / ${questions.length}',
                        style: const TextStyle(
                          fontSize: 18,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                      const SizedBox(height: 24),
                      Text(
                        q['question']?.toString() ?? '',
                        textAlign: TextAlign.center,
                        style: const TextStyle(
                          fontSize: 28,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                      const SizedBox(height: 12),
                      Text(
                        'Level: ${q['level'] ?? '-'}',
                        style: const TextStyle(fontSize: 16),
                      ),
                    ],
                  ),
                ),
                const SizedBox(height: 28),
                _answerButton(q, 'A', '${q['option_a']}', 'A'),
                _answerButton(q, 'B', '${q['option_b']}', 'B'),
                _answerButton(q, 'C', '${q['option_c']}', 'C'),
                _answerButton(q, 'D', '${q['option_d']}', 'D'),
                const Spacer(),
                Align(
                  alignment: Alignment.bottomRight,
                  child: ElevatedButton(
                    style: ElevatedButton.styleFrom(
                      backgroundColor: const Color(0xFFE85B5B),
                      foregroundColor: Colors.white,
                      padding: const EdgeInsets.symmetric(
                        horizontal: 28,
                        vertical: 14,
                      ),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(18),
                      ),
                    ),
                    onPressed: isSaving
                        ? null
                        : () async {
                            await _nextQuestion(questions);
                          },
                    child: isSaving
                        ? const SizedBox(
                            width: 22,
                            height: 22,
                            child: CircularProgressIndicator(
                              strokeWidth: 2.5,
                              color: Colors.white,
                            ),
                          )
                        : Text(
                            currentIndex == questions.length - 1
                                ? 'Selesai'
                                : 'Next',
                            style: const TextStyle(
                              fontSize: 22,
                              fontWeight: FontWeight.bold,
                            ),
                          ),
                  ),
                ),
              ],
            ),
          );
        },
      ),
    );
  }
}