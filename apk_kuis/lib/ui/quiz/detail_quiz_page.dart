import 'package:flutter/material.dart';
import '../../services/question_services.dart';

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

  Color _buttonColor(String optionKey) {
    if (selectedOption == optionKey) {
      return const Color(0xFFBDE7BD);
    }
    return const Color(0xFFD9C6F0);
  }

  Widget _answerButton(String label, String value, String optionKey) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 16),
      child: SizedBox(
        width: double.infinity,
        height: 56,
        child: ElevatedButton(
          style: ElevatedButton.styleFrom(
            backgroundColor: _buttonColor(optionKey),
            foregroundColor: Colors.black,
            elevation: 4,
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(28),
            ),
          ),
          onPressed: () {
            setState(() {
              selectedOption = optionKey;
            });
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

          final q = questions[currentIndex];

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
                        q['question'] ?? '',
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
                _answerButton('A', '${q['option_a']}', 'A'),
                _answerButton('B', '${q['option_b']}', 'B'),
                _answerButton('C', '${q['option_c']}', 'C'),
                _answerButton('D', '${q['option_d']}', 'D'),
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
                    onPressed: () {
                      if (currentIndex < questions.length - 1) {
                        setState(() {
                          currentIndex++;
                          selectedOption = null;
                        });
                      } else {
                        ScaffoldMessenger.of(context).showSnackBar(
                          const SnackBar(
                            content: Text('Quiz selesai'),
                          ),
                        );
                      }
                    },
                    child: const Text(
                      'Next',
                      style: TextStyle(
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