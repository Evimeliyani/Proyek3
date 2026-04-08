import 'dart:convert';
import 'package:http/http.dart' as http;
import '../core/app_config.dart';

class QuestionService {
  static Future<List<dynamic>> getQuestions(int quizId) async {
    final url = Uri.parse('${AppConfig.baseUrl}/quiz/$quizId/questions');

    final res = await http.get(
      url,
      headers: {
        'Accept': 'application/json',
      },
    );

    print('QUESTION URL: $url');
    print('QUESTION STATUS: ${res.statusCode}');
    print('QUESTION BODY: ${res.body}');

    if (res.statusCode == 200) {
      final body = jsonDecode(res.body);
      return body['data'] as List<dynamic>;
    } else {
      throw Exception('Gagal ambil soal');
    }
  }
}