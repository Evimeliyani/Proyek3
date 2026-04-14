import 'dart:math' as math;
import 'package:flutter/material.dart';
import '../home/home_page.dart';

class ResultQuizPage extends StatefulWidget {
  final int score;

  const ResultQuizPage({
    super.key,
    required this.score,
  });

  @override
  State<ResultQuizPage> createState() => _ResultQuizPageState();
}

class _ResultQuizPageState extends State<ResultQuizPage>
    with TickerProviderStateMixin {
  late final AnimationController _floatController;
  late final AnimationController _cardController;
  late final Animation<double> _cardScale;
  late final Animation<double> _titleFade;

  @override
  void initState() {
    super.initState();

    _floatController = AnimationController(
      vsync: this,
      duration: const Duration(seconds: 4),
    )..repeat(reverse: true);

    _cardController = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 900),
    );

    _cardScale = CurvedAnimation(
      parent: _cardController,
      curve: Curves.elasticOut,
    );

    _titleFade = CurvedAnimation(
      parent: _cardController,
      curve: Curves.easeOut,
    );

    _cardController.forward();
  }

  @override
  void dispose() {
    _floatController.dispose();
    _cardController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFFF5F1DD),
      body: AnimatedBuilder(
        animation: _floatController,
        builder: (context, child) {
          final t = _floatController.value;

          return Stack(
            children: [
              _buildTopBackground(),
              _buildFloatingCircle(
                top: 18 + (t * 12),
                right: 18,
                size: 92,
                color: const Color(0xFF9788F0),
                border: true,
              ),
              _buildFloatingDot(
                top: 44 - (t * 10),
                right: 98,
                size: 16,
                color: const Color(0xFF90E993),
              ),
              _buildFloatingDot(
                top: 92 + (t * 6),
                right: 0,
                size: 8,
                color: const Color(0xFFF25555),
              ),
              _buildFloatingCircle(
                top: 265 - (t * 10),
                left: -18,
                size: 92,
                color: const Color(0xFF9788F0),
                border: true,
              ),
              _buildFloatingDot(
                top: 292 + (t * 8),
                left: 58,
                size: 20,
                color: const Color(0xFF90E993),
              ),
              _buildFloatingDot(
                top: 344 - (t * 6),
                left: 10,
                size: 8,
                color: const Color(0xFFF25555),
              ),
              _buildFloatingCircle(
                bottom: 22 + (t * 10),
                right: 24,
                size: 110,
                color: const Color(0xFF9788F0),
                border: true,
              ),
              _buildFloatingDot(
                bottom: 66 - (t * 8),
                right: 114,
                size: 26,
                color: const Color(0xFF90E993),
              ),
              _buildFloatingDot(
                bottom: 84 + (t * 6),
                right: 0,
                size: 10,
                color: const Color(0xFFF25555),
              ),
              _buildFloatingEmoji(
                top: 76 + (t * 8),
                left: 26,
                emoji: '🐰',
                fontSize: 62,
              ),
              _buildFloatingEmoji(
                bottom: 162 - (t * 10),
                right: 20,
                emoji: '🐯',
                fontSize: 76,
              ),
              _buildFloatingEmoji(
                bottom: 184 + (t * 6),
                left: 14,
                emoji: '🎟️',
                fontSize: 58,
                angle: -0.35,
              ),
              SafeArea(
                child: Center(
                  child: Padding(
                    padding: const EdgeInsets.symmetric(horizontal: 22),
                    child: Column(
                      mainAxisAlignment: MainAxisAlignment.center,
                      children: [
                        FadeTransition(
                          opacity: _titleFade,
                          child: const Text(
                            'Selamat',
                            style: TextStyle(
                              fontSize: 48,
                              fontWeight: FontWeight.w500,
                              color: Colors.black,
                              fontFamily: 'serif',
                            ),
                          ),
                        ),
                        const SizedBox(height: 26),
                        ScaleTransition(
                          scale: _cardScale,
                          child: Container(
                            width: 320,
                            height: 320,
                            decoration: BoxDecoration(
                              color: const Color(0xFFD8C7F0),
                              borderRadius: BorderRadius.circular(50),
                              boxShadow: const [
                                BoxShadow(
                                  color: Colors.black12,
                                  blurRadius: 10,
                                  offset: Offset(0, 5),
                                ),
                              ],
                            ),
                            child: Center(
                              child: CustomPaint(
                                size: const Size(220, 220),
                                painter: BadgePainter(),
                                child: SizedBox(
                                  width: 220,
                                  height: 220,
                                  child: Center(
                                    child: Text(
                                      '${widget.score}',
                                      style: const TextStyle(
                                        fontSize: 74,
                                        fontWeight: FontWeight.bold,
                                        color: Colors.black,
                                      ),
                                    ),
                                  ),
                                ),
                              ),
                            ),
                          ),
                        ),
                        const SizedBox(height: 36),
                        TweenAnimationBuilder<double>(
                          tween: Tween(begin: 0, end: 1),
                          duration: const Duration(milliseconds: 1200),
                          curve: Curves.easeOutBack,
                          builder: (context, value, child) {
                            return Transform.translate(
                              offset: Offset(0, 30 * (1 - value)),
                              child: Opacity(
                                opacity: value,
                                child: child,
                              ),
                            );
                          },
                          child: SizedBox(
                            width: 145,
                            height: 48,
                            child: ElevatedButton(
                              style: ElevatedButton.styleFrom(
                                backgroundColor: const Color(0xFF0B57D0),
                                foregroundColor: Colors.white,
                                elevation: 4,
                                shape: RoundedRectangleBorder(
                                  borderRadius: BorderRadius.circular(18),
                                ),
                              ),
                              onPressed: () {
                                Navigator.pushAndRemoveUntil(
                                  context,
                                  MaterialPageRoute(
                                    builder: (_) => const HomePage(),
                                  ),
                                  (route) => false,
                                );
                              },
                              child: const Text(
                                'Home',
                                style: TextStyle(
                                  fontSize: 18,
                                  fontWeight: FontWeight.w500,
                                  fontFamily: 'serif',
                                ),
                              ),
                            ),
                          ),
                        ),
                      ],
                    ),
                  ),
                ),
              ),
            ],
          );
        },
      ),
    );
  }

  Widget _buildTopBackground() {
    return Align(
      alignment: Alignment.topCenter,
      child: Container(
        width: double.infinity,
        height: 560,
        decoration: const BoxDecoration(
          color: Color(0xFFAFC2F2),
          borderRadius: BorderRadius.only(
            bottomRight: Radius.circular(82),
          ),
          boxShadow: [
            BoxShadow(
              color: Colors.black26,
              blurRadius: 6,
              offset: Offset(0, 3),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildFloatingCircle({
    double? top,
    double? left,
    double? right,
    double? bottom,
    required double size,
    required Color color,
    bool border = false,
  }) {
    return Positioned(
      top: top,
      left: left,
      right: right,
      bottom: bottom,
      child: Container(
        width: size,
        height: size,
        decoration: BoxDecoration(
          shape: BoxShape.circle,
          border: border ? Border.all(color: Colors.white, width: 10) : null,
        ),
        child: CircleAvatar(
          backgroundColor: color,
        ),
      ),
    );
  }

  Widget _buildFloatingDot({
    double? top,
    double? left,
    double? right,
    double? bottom,
    required double size,
    required Color color,
  }) {
    return Positioned(
      top: top,
      left: left,
      right: right,
      bottom: bottom,
      child: CircleAvatar(
        radius: size,
        backgroundColor: color,
      ),
    );
  }

  Widget _buildFloatingEmoji({
    double? top,
    double? left,
    double? right,
    double? bottom,
    required String emoji,
    required double fontSize,
    double angle = 0,
  }) {
    return Positioned(
      top: top,
      left: left,
      right: right,
      bottom: bottom,
      child: Transform.rotate(
        angle: angle,
        child: Text(
          emoji,
          style: TextStyle(fontSize: fontSize),
        ),
      ),
    );
  }
}

class BadgePainter extends CustomPainter {
  @override
  void paint(Canvas canvas, Size size) {
    final paint = Paint()
      ..color = Colors.transparent
      ..style = PaintingStyle.fill;

    final border = Paint()
      ..color = Colors.black
      ..style = PaintingStyle.stroke
      ..strokeWidth = 4;

    final path = Path();
    final cx = size.width / 2;
    final cy = size.height / 2;
    final baseRadius = math.min(size.width, size.height) * 0.38;
    const waveCount = 8;
    const waveDepth = 14.0;

    for (int i = 0; i <= 360; i++) {
      final angle = i * math.pi / 180;
      final wave = math.sin(angle * waveCount) * waveDepth;
      final r = baseRadius + wave;
      final x = cx + r * math.cos(angle);
      final y = cy + r * math.sin(angle);

      if (i == 0) {
        path.moveTo(x, y);
      } else {
        path.lineTo(x, y);
      }
    }

    path.close();
    canvas.drawPath(path, paint);
    canvas.drawPath(path, border);
  }

  @override
  bool shouldRepaint(covariant CustomPainter oldDelegate) => false;
}