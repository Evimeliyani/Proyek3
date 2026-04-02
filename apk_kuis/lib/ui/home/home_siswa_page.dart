import 'package:flutter/material.dart';
import '../../core/token_storage.dart';
import '../auth/login_siswa_page.dart';

class HomeSiswaPage extends StatelessWidget {
  const HomeSiswaPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Home Siswa'),
        actions: [
          IconButton(
            icon: const Icon(Icons.logout),
            onPressed: () async {
              await TokenStorage.clear();
              if (context.mounted) {
                Navigator.pushAndRemoveUntil(
                  context,
                  MaterialPageRoute(builder: (_) => const LoginSiswaPage()),
                  (_) => false,
                );
              }
            },
          ),
        ],
      ),
      body: const Center(child: Text('Login/Daftar sukses ✅')),
    );
  }
}
