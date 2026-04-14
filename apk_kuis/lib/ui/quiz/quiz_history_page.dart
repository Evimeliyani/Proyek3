import 'package:flutter/material.dart';
import '../../services/quiz_history_service.dart';
import '../../services/user_service.dart';
import '../home/home_page.dart';

class QuizHistoryPage extends StatefulWidget {
  const QuizHistoryPage({super.key});

  @override
  State<QuizHistoryPage> createState() => _QuizHistoryPageState();
}

class _QuizHistoryPageState extends State<QuizHistoryPage> {
  bool isLoading = true;
  List<dynamic> quizHistory = [];
  String schoolName = 'SDN I LOBENER';

  int _selectedIndex = 1;

  @override
  void initState() {
    super.initState();
    loadData();
  }

  Future<void> loadData() async {
    try {
      final results = await Future.wait([
        UserService.getMe(),
        QuizHistoryService.getQuizHistory(),
      ]);

      final userData = results[0] as Map<String, dynamic>;
      final historyData = results[1] as List<dynamic>;

      final user = userData['user'] as Map<String, dynamic>;

      setState(() {
        schoolName = user['sekolah']?.toString() ?? 'SDN I LOBENER';
        quizHistory = historyData;
        isLoading = false;
      });
    } catch (e) {
      setState(() {
        isLoading = false;
      });

      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Gagal memuat riwayat quiz: $e')),
      );
    }
  }

  Color getCardColor(int index) {
    final colors = [
      const Color(0xFFF3CFCF),
      const Color(0xFFD4F0D1),
      const Color(0xFFD9CCF0),
    ];
    return colors[index % colors.length];
  }

  String formatTime(dynamic takenAt) {
    if (takenAt == null) return '-';

    try {
      final value = takenAt.toString();

      if (value.length == 5 && value.contains(':')) {
        return value;
      }

      final dateTime = DateTime.parse(value).toLocal();
      final hour = dateTime.hour.toString().padLeft(2, '0');
      final minute = dateTime.minute.toString().padLeft(2, '0');
      return '$hour:$minute';
    } catch (_) {
      return takenAt.toString();
    }
  }

  void _onItemTapped(int index) {
    if (_selectedIndex == index) return;

    setState(() {
      _selectedIndex = index;
    });

    if (index == 0) {
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(
          builder: (_) => const HomePage(),
        ),
      );
    } else if (index == 1) {
      // tetap di halaman riwayat quiz
    } else if (index == 2) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Halaman Tugas belum dibuat')),
      );
    } else if (index == 3) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Halaman Profil belum dibuat')),
      );
    }
  }

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
              GestureDetector(
                onTap: () {
                  Navigator.pop(context);
                },
                child: Container(
                  width: 34,
                  height: 34,
                  decoration: BoxDecoration(
                    shape: BoxShape.circle,
                    border: Border.all(color: Colors.black87, width: 2),
                  ),
                  child: const Icon(
                    Icons.arrow_back,
                    size: 20,
                    color: Colors.black87,
                  ),
                ),
              ),
              const SizedBox(width: 12),
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
          'Riwayat Pengerjaan',
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

  Widget _buildQuizCard({
    required String title,
    required String score,
    required String time,
    required Color color,
  }) {
    return Container(
      width: double.infinity,
      constraints: const BoxConstraints(minHeight: 98),
      decoration: BoxDecoration(
        color: color,
        borderRadius: BorderRadius.circular(18),
        border: Border.all(
          color: Colors.black54,
          width: 1,
        ),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.18),
            blurRadius: 8,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: Padding(
        padding: const EdgeInsets.fromLTRB(20, 14, 14, 10),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              title,
              style: const TextStyle(
                fontSize: 17,
                fontWeight: FontWeight.w700,
                color: Colors.black,
              ),
            ),
            const SizedBox(height: 8),
            Text(
              score,
              style: const TextStyle(
                fontSize: 16,
                fontWeight: FontWeight.w600,
                color: Colors.black,
              ),
            ),
            const SizedBox(height: 10),
            Align(
              alignment: Alignment.bottomRight,
              child: Text(
                time,
                style: const TextStyle(
                  fontSize: 13,
                  fontWeight: FontWeight.w500,
                  color: Colors.black,
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildHistoryList() {
    if (isLoading) {
      return const Expanded(
        child: Center(child: CircularProgressIndicator()),
      );
    }

    if (quizHistory.isEmpty) {
      return const Expanded(
        child: Center(
          child: Text(
            'Belum ada riwayat quiz',
            style: TextStyle(
              fontSize: 16,
              fontWeight: FontWeight.w500,
            ),
          ),
        ),
      );
    }

    return Expanded(
      child: Padding(
        padding: const EdgeInsets.symmetric(horizontal: 22),
        child: ListView.builder(
          padding: const EdgeInsets.only(top: 10, bottom: 12),
          itemCount: quizHistory.length,
          itemBuilder: (context, index) {
            final item = quizHistory[index];
            final kategori = item['kategori']?.toString() ?? '-';
            final score = item['score']?.toString() ?? '0';
            final jam = formatTime(item['taken_at']);

            return Padding(
              padding: const EdgeInsets.only(bottom: 22),
              child: _buildQuizCard(
                title: kategori,
                score: score,
                time: jam,
                color: getCardColor(index),
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
      body: Column(
        children: [
          _buildHeader(schoolName),
          _buildTitle(),
          _buildHistoryList(),
        ],
      ),
      bottomNavigationBar: _buildBottomNav(),
    );
  }
}