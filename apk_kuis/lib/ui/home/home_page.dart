import 'package:flutter/material.dart';
import '../../services/quiz_service.dart';
import '../quiz/detail_quiz_page.dart';

class HomePage extends StatelessWidget {
  const HomePage({super.key});

  Color _getIconColor(String title) {
    switch (title.toLowerCase()) {
      case 'penjumlahan':
        return Colors.orange;
      case 'pengurangan':
        return Colors.blue;
      case 'perkalian':
        return Colors.purple;
      case 'pembagian':
        return Colors.green;
      default:
        return Colors.black;
    }
  }

  IconData _getIconData(String title) {
    switch (title.toLowerCase()) {
      case 'penjumlahan':
        return Icons.add;
      case 'pengurangan':
        return Icons.remove;
      case 'perkalian':
        return Icons.close;
      case 'pembagian':
        return Icons.percent;
      default:
        return Icons.quiz;
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF4F1DE),
      appBar: AppBar(
        backgroundColor: const Color(0xFFAFC2F2),
        title: const Text(
          'Home',
          style: TextStyle(
            color: Colors.black,
            fontWeight: FontWeight.bold,
          ),
        ),
        elevation: 0,
        iconTheme: const IconThemeData(color: Colors.black),
      ),
      body: FutureBuilder<List<dynamic>>(
        future: QuizService.getQuiz(),
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

          final data = snapshot.data ?? [];

          if (data.isEmpty) {
            return const Center(
              child: Text('Data quiz kosong'),
            );
          }

          return Padding(
            padding: const EdgeInsets.all(20),
            child: GridView.builder(
              itemCount: data.length,
              gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
                crossAxisCount: 2,
                crossAxisSpacing: 20,
                mainAxisSpacing: 20,
                childAspectRatio: 0.85,
              ),
              itemBuilder: (context, index) {
                final quiz = data[index];
                final String title = quiz['title'] ?? '';

                return GestureDetector(
                  onTap: () {
                    Navigator.push(
                      context,
                      MaterialPageRoute(
                        builder: (_) => DetailQuizPage(
                          quizId: quiz['id'],
                          title: title,
                        ),
                      ),
                    );
                  },
                  child: Container(
                    decoration: BoxDecoration(
                      color: const Color(0xFFE7E7EE),
                      borderRadius: BorderRadius.circular(24),
                      border: Border.all(color: Colors.black, width: 1),
                      boxShadow: const [
                        BoxShadow(
                          color: Colors.black12,
                          blurRadius: 6,
                          offset: Offset(0, 4),
                        ),
                      ],
                    ),
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        Icon(
                          _getIconData(title),
                          size: 70,
                          color: _getIconColor(title),
                        ),
                        const SizedBox(height: 24),
                        Padding(
                          padding: const EdgeInsets.symmetric(horizontal: 8),
                          child: Text(
                            title,
                            textAlign: TextAlign.center,
                            style: const TextStyle(
                              fontSize: 17,
                              fontWeight: FontWeight.bold,
                            ),
                          ),
                        ),
                      ],
                    ),
                  ),
                );
              },
            ),
          );
        },
      ),
    );
  }
}