import 'package:flutter/material.dart';
import '../../services/user_service.dart';
import 'quiz_list_page.dart';

class QuizPage extends StatefulWidget {
  const QuizPage({super.key});

  @override
  State<QuizPage> createState() => _QuizPageState();
}

class _QuizPageState extends State<QuizPage> {
  int _selectedIndex = 1;

  void _onItemTapped(int index) {
    if (index == _selectedIndex) return;

    switch (index) {
      case 0:
        Navigator.pop(context);
        break;
      case 1:
        break;
      case 2:
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Halaman tugas belum dibuat')),
        );
        break;
      case 3:
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Halaman profil belum dibuat')),
        );
        break;
    }
  }

  Widget _buildHeader(String sekolah) {
    return Container(
      width: double.infinity,
      height: 140,
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
          padding: const EdgeInsets.fromLTRB(10, 14, 18, 18),
          child: Row(
            children: [
              IconButton(
                onPressed: () => Navigator.pop(context),
                icon: const Icon(
                  Icons.arrow_circle_left_outlined,
                  size: 28,
                  color: Colors.black,
                ),
              ),
              Expanded(
                child: Text(
                  sekolah,
                  maxLines: 1,
                  overflow: TextOverflow.ellipsis,
                  style: const TextStyle(
                    fontSize: 14,
                    fontWeight: FontWeight.w700,
                    decoration: TextDecoration.underline,
                    color: Colors.black,
                  ),
                ),
              ),
              const SizedBox(width: 10),
              const Icon(
                Icons.auto_stories,
                size: 42,
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
      padding: EdgeInsets.fromLTRB(12, 14, 12, 10),
      child: Align(
        alignment: Alignment.centerLeft,
        child: Text(
          'Matematika',
          style: TextStyle(
            fontSize: 20,
            fontWeight: FontWeight.w700,
            decoration: TextDecoration.underline,
            color: Colors.black,
          ),
        ),
      ),
    );
  }

  Widget _buildMenuButton({
  required String title,
  required Color color,
}) {
  return GestureDetector(
    onTap: () {
      Navigator.push(
        context,
        MaterialPageRoute(
          builder: (_) => QuizListPage(categoryTitle: title),
        ),
      );
    },
    child: Container(
      width: double.infinity, // 🔥 ini penting biar full kiri-kanan
      height: 70,
      decoration: BoxDecoration(
        color: color,
        borderRadius: BorderRadius.circular(14),
        border: Border.all(color: Colors.black38),
        boxShadow: const [
          BoxShadow(
            color: Colors.black26,
            blurRadius: 6,
            offset: Offset(2, 4),
          ),
        ],
      ),
      child: Center(
        child: Text(
          title,
          style: const TextStyle(
            fontSize: 20,
            fontWeight: FontWeight.w700,
          ),
        ),
      ),
    ),
  );
}

  Widget _buildMenuList() {
  return Expanded(
    child: SingleChildScrollView(
      child: Padding(
        padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 20),
        child: Column(
          children: [
            _buildMenuButton(
              title: 'Penjumlahan',
              color: const Color(0xFFF5CACA),
            ),
            const SizedBox(height: 16),
            _buildMenuButton(
              title: 'Pengurangan',
              color: const Color(0xFFD7F6D7),
            ),
            const SizedBox(height: 16),
            _buildMenuButton(
              title: 'Perkalian',
              color: const Color(0xFFD9CCFA),
            ),
            const SizedBox(height: 16),
            _buildMenuButton(
              title: 'Pembagian',
              color: const Color(0xFFF5E1CF),
            ),
          ],
        ),
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
      body: FutureBuilder<Map<String, dynamic>>(
        future: UserService.getMe(),
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(child: CircularProgressIndicator());
          }

          if (snapshot.hasError) {
            return Center(child: Text('Error: ${snapshot.error}'));
          }

          final data = snapshot.data ?? {};
          final user = (data['user'] as Map<String, dynamic>?) ?? {};
          final sekolah = user['sekolah']?.toString() ?? 'Sekolah';

          return Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              _buildHeader(sekolah),
              _buildTitle(),
              _buildMenuList(),
            ],
          );
        },
      ),
      bottomNavigationBar: _buildBottomNav(),
    );
  }
}