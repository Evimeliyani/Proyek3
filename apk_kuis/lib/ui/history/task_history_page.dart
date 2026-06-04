import 'package:flutter/material.dart';
import '../../services/task_history_service.dart';
import '../../services/user_service.dart';
import '../home/home_page.dart';
import '../profile/profile_page.dart';
import '../quiz/quiz_page.dart';
import 'history_page.dart';
import 'task_history_detail_page.dart';

class TaskHistoryPage extends StatefulWidget {
  const TaskHistoryPage({super.key});

  @override
  State<TaskHistoryPage> createState() => _TaskHistoryPageState();
}

class _TaskHistoryPageState extends State<TaskHistoryPage> {
  bool isLoading = true;

  List<dynamic> taskHistory = [];

  String schoolName = 'SDN I';

  int _selectedIndex = 2;

  String selectedKategori = 'Semua';

  @override
  void initState() {
    super.initState();
    loadData();
  }

  Future<void> loadData() async {
    try {
      final userData = await UserService.getMe();

      final user = userData['user'] as Map<String, dynamic>;

      final historyData = await TaskHistoryService.getTaskHistory();

      setState(() {
        schoolName = user['sekolah']?.toString() ?? 'SDN I';

        taskHistory = historyData;

        isLoading = false;
      });
    } catch (e) {
      setState(() {
        isLoading = false;
      });

      ScaffoldMessenger.of(
        context,
      ).showSnackBar(SnackBar(content: Text('Gagal memuat riwayat tugas: $e')));
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

  String formatTime(dynamic submittedAt) {
    if (submittedAt == null) return '-';

    try {
      final value = submittedAt.toString();

      final dateTime = DateTime.parse(value).toLocal();

      final hour = dateTime.hour.toString().padLeft(2, '0');

      final minute = dateTime.minute.toString().padLeft(2, '0');

      return '$hour:$minute';
    } catch (_) {
      return submittedAt.toString();
    }
  }

  void _onItemTapped(int index) {
    if (_selectedIndex == index) return;

    switch (index) {
      case 0:
        Navigator.pushReplacement(
          context,
          MaterialPageRoute(builder: (_) => const HomePage()),
        );
        break;

      case 1:
        Navigator.pushReplacement(
          context,
          MaterialPageRoute(builder: (_) => const QuizPage()),
        );
        break;

      case 2:
        break;

      case 3:
        Navigator.push(
          context,
          MaterialPageRoute(builder: (_) => const ProfilePage()),
        );
        break;
    }
  }

  Widget _buildHeader(String sekolah) {
    return Container(
      width: double.infinity,
      height: 170,
      decoration: const BoxDecoration(
        color: Color(0xFFAFC2F2),
        borderRadius: BorderRadius.only(bottomRight: Radius.circular(80)),
        boxShadow: [
          BoxShadow(color: Colors.black26, blurRadius: 5, offset: Offset(0, 3)),
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
                  Navigator.pushReplacement(
                    context,
                    MaterialPageRoute(builder: (_) => const HistoryPage()),
                  );
                },
                child: Container(
                  width: 30,
                  height: 30,
                  decoration: BoxDecoration(
                    shape: BoxShape.circle,
                    border: Border.all(color: Colors.black, width: 1.5),
                  ),
                  child: const Center(
                    child: Icon(
                      Icons.arrow_back,
                      size: 16,
                      color: Colors.black,
                    ),
                  ),
                ),
              ),

              const SizedBox(width: 14),

              Expanded(
                child: Text(
                  sekolah,
                  maxLines: 1,
                  overflow: TextOverflow.ellipsis,
                  style: const TextStyle(
                    fontSize: 18,
                    fontWeight: FontWeight.w700,
                    decoration: TextDecoration.underline,
                    color: Colors.black,
                  ),
                ),
              ),

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
          'Riwayat Pengerjaan Tugas',
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

  Widget _buildFilterSection() {
    return Padding(
      padding: const EdgeInsets.symmetric(horizontal: 22),
      child: Align(
        alignment: Alignment.centerLeft,
        child: Container(
          padding: const EdgeInsets.symmetric(horizontal: 12),
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.circular(12),
            border: Border.all(color: Colors.black12),
            boxShadow: [
              BoxShadow(
                color: Colors.black.withOpacity(0.08),
                blurRadius: 6,
                offset: const Offset(0, 2),
              ),
            ],
          ),
          child: DropdownButtonHideUnderline(
            child: DropdownButton<String>(
              value: selectedKategori,
              icon: const Icon(Icons.keyboard_arrow_down_rounded),
              borderRadius: BorderRadius.circular(12),
              dropdownColor: Colors.white,
              items: const [
                DropdownMenuItem(value: 'Semua', child: Text('Semua')),
                DropdownMenuItem(
                  value: 'Penjumlahan',
                  child: Text('Penjumlahan'),
                ),
                DropdownMenuItem(
                  value: 'Pengurangan',
                  child: Text('Pengurangan'),
                ),
                DropdownMenuItem(value: 'Perkalian', child: Text('Perkalian')),
                DropdownMenuItem(value: 'Pembagian', child: Text('Pembagian')),
              ],
              onChanged: (value) {
                setState(() {
                  selectedKategori = value!;
                });
              },
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildTaskCard({
    required String title,
    required String nilai,
    required String time,
    required Color color,
  }) {
    return Container(
      width: double.infinity,
      constraints: const BoxConstraints(minHeight: 98),
      decoration: BoxDecoration(
        color: color,
        borderRadius: BorderRadius.circular(18),
        border: Border.all(color: Colors.black54, width: 1),
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
              style: const TextStyle(fontSize: 17, fontWeight: FontWeight.w700),
            ),

            const SizedBox(height: 8),

            Text(
              nilai,
              style: const TextStyle(fontSize: 16, fontWeight: FontWeight.w600),
            ),

            const SizedBox(height: 10),

            Align(
              alignment: Alignment.bottomRight,
              child: Text(
                time,
                style: const TextStyle(
                  fontSize: 13,
                  fontWeight: FontWeight.w500,
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
      return const Expanded(child: Center(child: CircularProgressIndicator()));
    }

    final filteredHistory = selectedKategori == 'Semua'
        ? taskHistory
        : taskHistory.where((item) {
            return item['kategori']?.toString().toLowerCase() ==
                selectedKategori.toLowerCase();
          }).toList();

    if (filteredHistory.isEmpty) {
      return const Expanded(
        child: Center(
          child: Text(
            'Belum ada riwayat tugas',
            style: TextStyle(fontSize: 16, fontWeight: FontWeight.w500),
          ),
        ),
      );
    }

    return Expanded(
      child: Padding(
        padding: const EdgeInsets.symmetric(horizontal: 22),
        child: ListView.builder(
          padding: const EdgeInsets.only(top: 10, bottom: 12),
          itemCount: filteredHistory.length,
          itemBuilder: (context, index) {
            final item = filteredHistory[index];

            final judul = item['judul']?.toString() ?? 'Tugas';

            final nilai = item['nilai']?.toString() ?? '0';

            final jam = formatTime(item['submitted_at']);

            return Padding(
              padding: const EdgeInsets.only(bottom: 22),
              child: InkWell(
                borderRadius: BorderRadius.circular(18),
                onTap: () {
                  Navigator.push(
                    context,
                    MaterialPageRoute(
                      builder: (_) => TaskHistoryDetailPage(item: item),
                    ),
                  );
                },
                child: _buildTaskCard(
                  title: judul,
                  nilai: 'Nilai : $nilai',
                  time: jam,
                  color: getCardColor(index),
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
            BottomNavigationBarItem(icon: Icon(Icons.home), label: 'Home'),
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
          _buildFilterSection(),
          const SizedBox(height: 10),
          _buildHistoryList(),
        ],
      ),
      bottomNavigationBar: _buildBottomNav(),
    );
  }
}
