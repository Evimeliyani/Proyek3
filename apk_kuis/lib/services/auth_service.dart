import 'dart:convert';
import 'package:http/http.dart' as http;
import '../core/app_config.dart';

class AuthService {
  static Future<Map<String, dynamic>> loginSiswa({
    required String email,
    required String password,
  }) async {
    final url = Uri.parse('${AppConfig.baseUrl}/auth/login');

    final res = await http.post(
      url,
      headers: const {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
      body: jsonEncode({
        'client': 'mobile_siswa',
        'email': email,
        'password': password,
      }),
    );

    return _handleResponse(res);
  }

  static Future<Map<String, dynamic>> registerSiswa({
    required String email,
    required String password,
    required String name,
    required String kelas,
    required String sekolah,
  }) async {
    final url = Uri.parse('${AppConfig.baseUrl}/auth/register');

    final res = await http.post(
      url,
      headers: const {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
      body: jsonEncode({
        'client': 'mobile_siswa',
        'email': email,
        'password': password,
        'name': name,
        'kelas': kelas,
        'sekolah': sekolah,
      }),
    );

    return _handleResponse(res);
  }

  static Map<String, dynamic> _handleResponse(http.Response res) {
    dynamic data;
    try {
      data = jsonDecode(res.body);
    } catch (_) {
      throw 'Response bukan JSON: ${res.body}';
    }

    if (res.statusCode >= 200 && res.statusCode < 300) {
      return data as Map<String, dynamic>;
    }

    if (data is Map && data['errors'] is Map) {
      final errorsMap = data['errors'] as Map;
      final msg = errorsMap.values.expand((v) => (v as List)).join('\n');
      throw msg.toString();
    }

    throw (data is Map ? (data['message'] ?? 'Request gagal') : 'Request gagal');
  }
}
