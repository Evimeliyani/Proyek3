import 'package:flutter/material.dart';
import '../../services/quiz_service.dart';
import '../../services/user_service.dart';
import '../quiz/detail_quiz_page.dart';
import '../profile/profile_page.dart';

class HomePage extends StatefulWidget {
  const HomePage({super.key});

  @override
  State<HomePage> createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  int _selectedIndex = 0;

  Color _getIconColor(String title) {
    switch (title.toLowerCase()) {
      case 'penjumlahan':
        return const Color(0xFFFFB300);
      case 'pengurangan':
        return const Color(0xFF1E4DFF);
      case 'perkalian':
        return const Color(0xFF9C0AA5);
      case 'pembagian':
        return const Color(0xFF0A9800);
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

  void _onItemTapped(int index) {
    if (index == _selectedIndex) return;

    setState(() {
      _selectedIndex = index;
    });

    switch (index) {
      case 0:
        break;
      case 1:
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Halaman quiz belum dibuat')),
        );
        break;
      case 2:
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Halaman tugas belum dibuat')),
        );
        break;
      case 3:
        Navigator.push(
          context,
          MaterialPageRoute(
            builder: (_) => const ProfilePage(),
          ),
        ).then((_) {
          setState(() {
            _selectedIndex = 0;
          });
        });
        break;
    }
  }

  /// HEADER TANPA TOMBOL BACK
  Widget _buildHeader(String sekolah) {
    return Container(
      width: double.infinity,
      height: 170,
      decoration: const BoxDecoration(
        color: Color(0xFFAFC2F2),
        borderRadius: BorderRadius.only(
          bottomRight: Radius.circular(80),
        ),
        boxShadow: [
          BoxShadow(
            color: Colors.black26,
            blurRadius: 5,
            offset: Offset(0, 3),
          ),
        ],
      ),
      child: SafeArea(
        bottom: false,
        child: Padding(
          padding: const EdgeInsets.fromLTRB(22, 20, 22, 18),
          child: Row(
            children: [
              Expanded(
                child: Text(
                  sekolah,
                  maxLines: 1,
                  overflow: TextOverflow.ellipsis,
                  style: const TextStyle(
                    fontSize: 17,
                    fontWeight: FontWeight.w700,
                    decoration: TextDecoration.underline,
                    color: Colors.black,
                  ),
                ),
              ),
              const SizedBox(width: 8),
              const Icon(
                Icons.menu_book_rounded,
                size: 58,
                color: Color(0xFF2E2ED8),
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildTitle() {
    return const Padding(
      padding: EdgeInsets.fromLTRB(30, 26, 30, 10),
      child: Align(
        alignment: Alignment.centerLeft,
        child: Text(
          'Home',
          style: TextStyle(
            fontSize: 24,
            fontWeight: FontWeight.w700,
            decoration: TextDecoration.underline,
            color: Colors.black,
          ),
        ),
      ),
    );
  }

  Widget _buildQuizGrid(List<dynamic> data) {
    return Expanded(
      child: Padding(
        padding: const EdgeInsets.symmetric(horizontal: 22),
        child: GridView.builder(
          padding: const EdgeInsets.only(top: 10, bottom: 12),
          itemCount: data.length,
          gridDelegate: const SliverGridDelegateWithFixedCrossAxisCount(
            crossAxisCount: 2,
            crossAxisSpacing: 22,
            mainAxisSpacing: 22,
            childAspectRatio: 0.82,
          ),
          itemBuilder: (context, index) {
            final quiz = data[index];
            final String title = quiz['title']?.toString() ?? '';

            return GestureDetector(
              onTap: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(
                    builder: (_) => DetailQuizPage(
                      quizId: quiz['id'] as int,
                      title: title,
                    ),
                  ),
                );
              },
              child: Container(
                decoration: BoxDecoration(
                  color: const Color(0xFFE4E5EC),
                  borderRadius: BorderRadius.circular(24),
                  border: Border.all(
                    color: Colors.black,
                    width: 1.2,
                  ),
                  boxShadow: const [
                    BoxShadow(
                      color: Colors.black12,
                      blurRadius: 8,
                      offset: Offset(0, 4),
                    ),
                  ],
                ),
                child: Padding(
                  padding: const EdgeInsets.symmetric(
                    horizontal: 12,
                    vertical: 18,
                  ),
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Icon(
                        _getIconData(title),
                        size: 78,
                        color: _getIconColor(title),
                      ),
                      const SizedBox(height: 24),
                      Text(
                        title,
                        textAlign: TextAlign.center,
                        style: const TextStyle(
                          fontSize: 17,
                          fontWeight: FontWeight.w700,
                          color: Colors.black,
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            );
          },
        ),
      ),
    );
  }

  Widget _buildBottomNav() {
    return SafeArea(
      top: false,
      child: SizedBox(
        height: 72,
        child: BottomNavigationBar(
          currentIndex: _selectedIndex,
          onTap: _onItemTapped,
          type: BottomNavigationBarType.fixed,
          backgroundColor: const Color(0xFFAFC2F2),
          selectedItemColor: Colors.black,
          unselectedItemColor: Colors.black,
          showSelectedLabels: false,
          showUnselectedLabels: false,
          elevation: 0,
          iconSize: 28,
          items: const [
            BottomNavigationBarItem(
              icon: Icon(Icons.home),
              label: 'Home',
            ),
            BottomNavigationBarItem(
              icon: Icon(Icons.quiz_outlined),
              label: 'Quiz',
            ),
            BottomNavigationBarItem(
              icon: Icon(Icons.assignment_turned_in_outlined),
              label: 'Tugas',
            ),
            BottomNavigationBarItem(
              icon: Icon(Icons.account_circle_outlined),
              label: 'Profil',
            ),
          ],
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF5F1DD),
      body: FutureBuilder<List<dynamic>>(
        future: Future.wait([
          UserService.getMe(),
          QuizService.getQuiz(),
        ]),
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(
              child: CircularProgressIndicator(),
            );
          }

          if (snapshot.hasError) {
            return Center(
              child: Text('Error: ${snapshot.error}'),
            );
          }

          final result = snapshot.data!;
          final userData = result[0] as Map<String, dynamic>;
          final quizData = result[1] as List<dynamic>;

          final user = userData['user'] as Map<String, dynamic>;
          final sekolah = user['sekolah']?.toString() ?? 'Sekolah';

          return Column(
            children: [
              _buildHeader(sekolah),
              _buildTitle(),
              _buildQuizGrid(quizData),
            ],
          );
        },
      ),
      bottomNavigationBar: _buildBottomNav(),
    );
  }
}