import 'dart:convert';
import 'package:http/http.dart' as http;

import '../core/app_config.dart';
import '../core/token_storage.dart';

class TaskHistoryService {

  static Future<List<dynamic>> getTaskHistory() async {

    final token = await TokenStorage.getToken();

    if (token == null || token.isEmpty) {
      throw Exception('Token tidak ditemukan');
    }

    final url =
        Uri.parse('${AppConfig.baseUrl}/task-history');

    final res = await http.get(
      url,
      headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );

    print('TASK HISTORY URL: $url');
    print('TASK HISTORY STATUS: ${res.statusCode}');
    print('TASK HISTORY BODY: ${res.body}');

    if (res.statusCode == 200) {

      final body = jsonDecode(res.body);

      if (body is List) {
        return body;
      }

      if (body is Map<String, dynamic> &&
          body['data'] != null) {
        return body['data'];
      }

      return [];

    } else {

      throw Exception(
        'Status ${res.statusCode}: ${res.body}',
      );
    }
  }
}