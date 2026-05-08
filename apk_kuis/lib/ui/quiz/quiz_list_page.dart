import 'package:flutter/material.dart';
import '../../services/user_service.dart';

class QuizListPage extends StatefulWidget {
  final String categoryTitle;

  const QuizListPage({
    super.key,
    required this.categoryTitle,
  });

  @override
  State<QuizListPage> createState() => _QuizListPageState();
}

class _QuizListPageState extends State<QuizListPage> {
  final List<Color> colors = const [
    Color(0xFFF5CACA),
    Color(0xFFD7F6D7),
    Color(0xFFD9CCFA),
    Color(0xFFF5E1CF),
  ];

  Widget _buildHeader(String sekolah) {
    return Container(
      width: double.infinity,
      height: 140,
      decoration: const BoxDecoration(
        color: Color(0xFFAFC2F2),
        borderRadius: BorderRadius.only(
          bottomRight: Radius.circular(80),
        ),
        boxShadow: [
          BoxShadow(
            color: Colors.black26,
            blurRadius: 5,
            offset: Offset(0, 3),
          ),
        ],
      ),
      child: SafeArea(
        bottom: false,
        child: Padding(
          padding: const EdgeInsets.fromLTRB(10, 14, 18, 18),
          child: Row(
            children: [
              IconButton(
                onPressed: () => Navigator.pop(context),
                icon: const Icon(
                  Icons.arrow_circle_left_outlined,
                  size: 28,
                  color: Colors.black,
                ),
              ),
              Expanded(
                child: Text(
                  sekolah,
                  maxLines: 1,
                  overflow: TextOverflow.ellipsis,
                  style: const TextStyle(
                    fontSize: 14,
                    fontWeight: FontWeight.w700,
                    decoration: TextDecoration.underline,
                    color: Colors.black,
                  ),
                ),
              ),
              const SizedBox(width: 10),
              const Icon(
              Icons.menu_book_rounded,
              size: 58,
              color: Color(0xFF2E2ED8),
            ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildTitle() {
    return Padding(
      padding: const EdgeInsets.fromLTRB(12, 24, 12, 10),
      child: Align(
        alignment: Alignment.centerLeft,
        child: Text(
          widget.categoryTitle,
          style: const TextStyle(
            fontSize: 20,
            fontWeight: FontWeight.w700,
            decoration: TextDecoration.underline,
            color: Colors.black,
          ),
        ),
      ),
    );
  }

  void _openCamera(int index) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(
        content: Text(
          'Membuka kamera ${widget.categoryTitle} ${index + 1}',
        ),
      ),
    );

    // nanti arahkan ke halaman kamera di sini
  }

  Widget _buildQuizCard(int index) {
    final quizTitle = '${widget.categoryTitle} ${index + 1}';

    return Padding(
      padding: const EdgeInsets.only(bottom: 20),
      child: InkWell(
        borderRadius: BorderRadius.circular(14),
        onTap: () => _openCamera(index),
        child: Container(
          width: double.infinity,
          height: 70,
          decoration: BoxDecoration(
            color: colors[index],
            borderRadius: BorderRadius.circular(14),
            border: Border.all(color: Colors.black38),
            boxShadow: const [
              BoxShadow(
                color: Colors.black26,
                blurRadius: 6,
                offset: Offset(2, 4),
              ),
            ],
          ),
          child: Row(
            children: [
              const SizedBox(width: 18),

              Expanded(
                child: Text(
                  quizTitle,
                  style: const TextStyle(
                    fontSize: 18,
                    fontWeight: FontWeight.w700,
                  ),
                ),
              ),

              const Icon(
                Icons.center_focus_strong_outlined,
                size: 30,
                color: Colors.black54,
              ),

              const SizedBox(width: 18),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildQuizList() {
    return Expanded(
      child: SingleChildScrollView(
        child: Padding(
          padding: const EdgeInsets.fromLTRB(28, 16, 28, 20),
          child: Column(
            children: List.generate(4, (index) {
              return _buildQuizCard(index);
            }),
          ),
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF5F1DD),
      body: FutureBuilder<Map<String, dynamic>>(
        future: UserService.getMe(),
        builder: (context, snapshot) {
          final data = snapshot.data ?? {};
          final user = (data['user'] as Map<String, dynamic>?) ?? {};
          final sekolah = user['sekolah']?.toString() ?? 'Sekolah';

          return Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              _buildHeader(sekolah),
              _buildTitle(),
              _buildQuizList(),
            ],
          );
        },
      ),
    );
  }
}