import 'dart:convert';
import 'package:http/http.dart' as http;
import '../core/app_config.dart';
import '../core/token_storage.dart';

class UserService {
  static Future<Map<String, dynamic>> getMe() async {
    final token = await TokenStorage.getToken();

    if (token == null || token.isEmpty) {
      throw Exception('Token tidak ditemukan');
    }

    final url = Uri.parse('${AppConfig.baseUrl}/me');

    final res = await http.get(
      url,
      headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );

    print('ME URL: $url');
    print('ME STATUS: ${res.statusCode}');
    print('ME BODY: ${res.body}');

    if (res.statusCode == 200) {
      return jsonDecode(res.body) as Map<String, dynamic>;
    } else {
      throw Exception('Gagal mengambil data user');
    }
  }
}