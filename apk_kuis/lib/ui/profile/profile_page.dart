import 'package:flutter/material.dart';
import '../../services/user_service.dart';

class ProfilePage extends StatefulWidget {
  const ProfilePage({super.key});

  @override
  State<ProfilePage> createState() => _ProfilePageState();
}

class _ProfilePageState extends State<ProfilePage> {
  int _selectedIndex = 3;

  void _onItemTapped(int index) {
    if (index == _selectedIndex) return;

    setState(() {
      _selectedIndex = index;
    });

    switch (index) {
      case 0:
        Navigator.pop(context);
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
        break;
    }
  }

  /// HEADER (SUDAH ADA TITLE PROFIL DI DALAM)
  Widget _buildHeader() {
    return Container(
      width: double.infinity,
      height: 120,
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
      child: const SafeArea(
        bottom: false,
        child: Padding(
          padding: EdgeInsets.fromLTRB(22, 20, 22, 18),
          child: Align(
            alignment: Alignment.centerLeft,
            child: Text(
              'Profil',
              style: TextStyle(
                fontSize: 24,
                fontWeight: FontWeight.w700,
                decoration: TextDecoration.underline,
                color: Colors.black,
              ),
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildProfileCard(Map<String, dynamic> user) {
    final String name = user['name']?.toString() ?? '-';
    final String email = user['email']?.toString() ?? '-';
    final String role = user['role']?.toString() ?? '-';
    final String kelas = user['kelas']?.toString() ?? '-';
    final String sekolah = user['sekolah']?.toString() ?? '-';

    return Expanded(
      child: SingleChildScrollView(
        padding: const EdgeInsets.fromLTRB(22, 10, 22, 12),
        child: Container(
          width: double.infinity,
          padding: const EdgeInsets.all(20),
          decoration: BoxDecoration(
            color: const Color(0xFFE4E5EC),
            borderRadius: BorderRadius.circular(24),
            border: Border.all(color: Colors.black, width: 1.2),
            boxShadow: const [
              BoxShadow(
                color: Colors.black12,
                blurRadius: 8,
                offset: Offset(0, 4),
              ),
            ],
          ),
          child: Column(
            children: [
              const CircleAvatar(
                radius: 42,
                backgroundColor: Color(0xFFAFC2F2),
                child: Icon(
                  Icons.person,
                  size: 50,
                  color: Colors.black,
                ),
              ),
              const SizedBox(height: 18),
              Text(
                name,
                textAlign: TextAlign.center,
                style: const TextStyle(
                  fontSize: 22,
                  fontWeight: FontWeight.w700,
                  color: Colors.black,
                ),
              ),
              const SizedBox(height: 24),
              _buildProfileItem('Email', email),
              _buildProfileItem('Role', role),
              _buildProfileItem('Kelas', kelas),
              _buildProfileItem('Sekolah', sekolah),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildProfileItem(String label, String value) {
    return Container(
      width: double.infinity,
      margin: const EdgeInsets.only(bottom: 14),
      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 14),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        border: Border.all(color: Colors.black12),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            label,
            style: const TextStyle(
              fontSize: 13,
              fontWeight: FontWeight.w600,
              color: Colors.black54,
            ),
          ),
          const SizedBox(height: 4),
          Text(
            value.isEmpty ? '-' : value,
            style: const TextStyle(
              fontSize: 17,
              fontWeight: FontWeight.w700,
              color: Colors.black,
            ),
          ),
        ],
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
              icon: Icon(Icons.account_circle),
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
            return const Center(
              child: CircularProgressIndicator(),
            );
          }

          if (snapshot.hasError) {
            return Center(
              child: Text('Error: ${snapshot.error}'),
            );
          }

          final data = snapshot.data ?? {};
          final user = (data['user'] as Map<String, dynamic>?) ?? {};

          return Column(
            children: [
              _buildHeader(),
              _buildProfileCard(user),
            ],
          );
        },
      ),
      bottomNavigationBar: _buildBottomNav(),
    );
  }
}