import 'dart:convert';
import 'package:http/http.dart' as http;
import '../core/app_config.dart';
import '../core/token_storage.dart';

class QuizHistoryService {
  static Future<List<dynamic>> getQuizHistory() async {
    final token = await TokenStorage.getToken();

    if (token == null || token.isEmpty) {
      throw Exception('Token tidak ditemukan');
    }

    final url = Uri.parse('${AppConfig.baseUrl}/quiz-history');

    final res = await http.get(
      url,
      headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );

    print('HISTORY URL: $url');
    print('HISTORY STATUS: ${res.statusCode}');
    print('HISTORY BODY: ${res.body}');

    if (res.statusCode == 200) {
      final body = jsonDecode(res.body);

      if (body is List) {
        return body;
      }

      if (body is Map<String, dynamic> && body['data'] != null) {
        return body['data'];
      }

      return [];
    } else {
      throw Exception('Gagal mengambil riwayat quiz');
    }
  }
}