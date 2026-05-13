import 'package:shared_preferences/shared_preferences.dart';

class TokenStorage {
  static const _kToken = 'auth_token';

  // SIMPAN TOKEN
  static Future<void> saveToken(String token) async {
    final sp = await SharedPreferences.getInstance();
    await sp.setString(_kToken, token);
  }

  // AMBIL TOKEN
  static Future<String?> getToken() async {
    final sp = await SharedPreferences.getInstance();
    return sp.getString(_kToken);
  }

  // HAPUS TOKEN (LOGOUT)
  static Future<void> clear() async {
    final sp = await SharedPreferences.getInstance();
    await sp.remove(_kToken);
  }
}