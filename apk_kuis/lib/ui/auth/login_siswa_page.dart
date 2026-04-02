import 'package:flutter/material.dart';
import '../../core/token_storage.dart';
import '../../services/auth_service.dart';
import '../widgets/auth_background.dart';
import 'register_siswa_page.dart';
import '../home/home_siswa_page.dart';

class LoginSiswaPage extends StatefulWidget {
  const LoginSiswaPage({super.key});

  @override
  State<LoginSiswaPage> createState() => _LoginSiswaPageState();
}

class _LoginSiswaPageState extends State<LoginSiswaPage> {
  final emailC = TextEditingController();
  final passC = TextEditingController();
  bool loading = false;

  @override
  void dispose() {
    emailC.dispose();
    passC.dispose();
    super.dispose();
  }

  Future<void> _login() async {
    setState(() => loading = true);
    try {
      final res = await AuthService.loginSiswa(
        email: emailC.text.trim(),
        password: passC.text,
      );

      final token = (res['token'] ?? '').toString();
      if (token.isNotEmpty) {
        await TokenStorage.saveToken(token);
      }

      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(const SnackBar(content: Text('Login berhasil ✅')));

      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (_) => const HomeSiswaPage()),
      );
    } catch (e) {
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(SnackBar(content: Text(e.toString())));
    } finally {
      if (mounted) setState(() => loading = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    return AuthBackground(
      child: Center(
        child: Container(
          width: 320,
          padding: const EdgeInsets.symmetric(horizontal: 18, vertical: 22),
          decoration: BoxDecoration(
            color: const Color(0xFFE9ECFF),
            borderRadius: BorderRadius.circular(22),
            boxShadow: const [BoxShadow(blurRadius: 20, offset: Offset(0, 12), color: Colors.black26)],
          ),
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              const Text('Login', style: TextStyle(fontSize: 22, fontWeight: FontWeight.w700)),
              const SizedBox(height: 14),

              _label('Email'),
              _field(controller: emailC),

              const SizedBox(height: 12),
              _label('Password'),
              _field(controller: passC, obscure: true),

              const SizedBox(height: 18),
              SizedBox(
                width: 130,
                height: 40,
                child: ElevatedButton(
                  onPressed: loading ? null : _login,
                  style: ElevatedButton.styleFrom(
                    backgroundColor: const Color(0xFF1877F2),
                    shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(22)),
                  ),
                  child: loading
                      ? const SizedBox(width: 18, height: 18, child: CircularProgressIndicator(strokeWidth: 2))
                      : const Text('Login', style: TextStyle(color: Colors.white, fontWeight: FontWeight.w700)),
                ),
              ),

              const SizedBox(height: 10),
              Row(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  const Text('Belum memiliki akun? '),
                  GestureDetector(
                    onTap: () {
                      Navigator.push(context, MaterialPageRoute(builder: (_) => const RegisterSiswaPage()));
                    },
                    child: const Text('Daftar disini', style: TextStyle(color: Colors.blue, fontWeight: FontWeight.w600)),
                  ),
                ],
              )
            ],
          ),
        ),
      ),
    );
  }

  Widget _label(String t) => Align(
        alignment: Alignment.centerLeft,
        child: Text(t, style: const TextStyle(fontSize: 14, fontWeight: FontWeight.w600)),
      );

  Widget _field({required TextEditingController controller, bool obscure = false}) {
    return Container(
      margin: const EdgeInsets.only(top: 6),
      decoration: BoxDecoration(color: const Color(0xFFDADADA), borderRadius: BorderRadius.circular(14)),
      child: TextField(
        controller: controller,
        obscureText: obscure,
        decoration: const InputDecoration(
          border: InputBorder.none,
          contentPadding: EdgeInsets.symmetric(horizontal: 14, vertical: 14),
        ),
      ),
    );
  }
}
