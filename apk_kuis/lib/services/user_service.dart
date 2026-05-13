import 'dart:convert';
import 'dart:io';
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

  static Future<String> uploadProfilePhoto(File imageFile) async {
    final token = await TokenStorage.getToken();

    if (token == null || token.isEmpty) {
      throw Exception('Token tidak ditemukan');
    }

    final url = Uri.parse('${AppConfig.baseUrl}/profile/photo');

    final request = http.MultipartRequest('POST', url);

    request.headers['Accept'] = 'application/json';
    request.headers['Authorization'] = 'Bearer $token';

    request.files.add(
      await http.MultipartFile.fromPath(
        'photo',
        imageFile.path,
      ),
    );

    final response = await request.send();
    final responseBody = await response.stream.bytesToString();

    print('UPLOAD PHOTO URL: $url');
    print('UPLOAD PHOTO STATUS: ${response.statusCode}');
    print('UPLOAD PHOTO BODY: $responseBody');

    if (response.statusCode == 200) {
      return responseBody;
    } else {
      throw Exception('Gagal upload foto profil: $responseBody');
    }
  }

  // LOGOUT
  static Future<void> logout() async {
    final token = await TokenStorage.getToken();

    if (token == null || token.isEmpty) {
      throw Exception('Token tidak ditemukan');
    }

    final url = Uri.parse('${AppConfig.baseUrl}/auth/logout');

    final res = await http.post(
      url,
      headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );

    print('LOGOUT URL: $url');
    print('LOGOUT STATUS: ${res.statusCode}');
    print('LOGOUT BODY: ${res.body}');

    if (res.statusCode == 200) {
      await TokenStorage.clear();
    } else {
      throw Exception('Logout gagal');
    }
  }
}