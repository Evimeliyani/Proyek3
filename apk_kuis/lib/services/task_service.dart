import 'dart:convert';
import 'package:http/http.dart' as http;

class TaskService {

  // GANTI SESUAI IP LARAVEL
  static const String baseUrl =
      'http://10.0.171.152:8000/api';

  // =========================
  // AMBIL TUGAS BERDASARKAN KATEGORI
  // =========================
  static Future<List<dynamic>>
      getTasksByKategori(
    String kategori,
  ) async {

    final response = await http.get(
      Uri.parse(
        '$baseUrl/student/tasks/$kategori',
      ),
    );

    if (response.statusCode == 200) {

      final data =
          jsonDecode(response.body);

      return data['data'];

    } else {

      throw Exception(
        'Gagal mengambil tugas',
      );
    }
  }
}