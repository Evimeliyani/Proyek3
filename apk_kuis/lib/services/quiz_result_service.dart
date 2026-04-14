import 'dart:convert';
import 'package:http/http.dart' as http;
import '../core/app_config.dart';
import '../core/token_storage.dart';

class QuizResultService {
  static Future<void> saveResult({
    required int quizId,
    required int score,
  }) async {
    final token = await TokenStorage.getToken();

    if (token == null || token.isEmpty) {
      throw Exception('Token tidak ditemukan');
    }

    final url = Uri.parse('${AppConfig.baseUrl}/quiz-results');

    final res = await http.post(
      url,
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Authorization': 'Bearer $token',
      },
      body: jsonEncode({
        'quiz_id': quizId,
        'score': score,
      }),
    );

    print('SAVE RESULT URL: $url');
    print('SAVE RESULT STATUS: ${res.statusCode}');
    print('SAVE RESULT BODY: ${res.body}');

    if (res.statusCode != 201) {
      throw Exception('Gagal menyimpan hasil quiz');
    }
  }
}