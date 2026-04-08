import 'dart:convert';
import 'package:http/http.dart' as http;
import '../core/app_config.dart';

class QuizService {
  static Future<List<dynamic>> getQuiz() async {
    final res = await http.get(
      Uri.parse('${AppConfig.baseUrl}/quiz'),
      headers: {
        'Accept': 'application/json',
      },
    );

    print(res.body);

    if (res.statusCode == 200) {
      return jsonDecode(res.body)['data'];
    } else {
      throw Exception('Gagal ambil quiz');
    }
  }
}