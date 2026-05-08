import 'dart:async';
import 'package:flutter/material.dart';
import '../home/home_page.dart';

class MathLoadingPage extends StatefulWidget {
  const MathLoadingPage({super.key});

  @override
  State<MathLoadingPage> createState() => _MathLoadingPageState();
}

class _MathLoadingPageState extends State<MathLoadingPage>
    with TickerProviderStateMixin {
  late AnimationController _moveController;
  late AnimationController _progressController;

  @override
  void initState() {
    super.initState();

    _moveController = AnimationController(
      vsync: this,
      duration: const Duration(milliseconds: 850),
    )..repeat(reverse: true);

    _progressController = AnimationController(
      vsync: this,
      duration: const Duration(seconds: 4),
    )..forward();

    Timer(const Duration(seconds: 4), () {
      if (!mounted) return;
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(builder: (_) => const HomePage()),
      );
    });
  }

  @override
  void dispose() {
    _moveController.dispose();
    _progressController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final screenWidth = MediaQuery.of(context).size.width;
    final isWide = screenWidth > 700;

    return Scaffold(
      backgroundColor: const Color(0xFFF4F1DE),
      body: SafeArea(
        child: AnimatedBuilder(
          animation: _moveController,
          builder: (context, _) {
            final move = _moveController.value;

            return Center(
              child: SingleChildScrollView(
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    const Text(
                      'Siap Belajar MTK?',
                      style: TextStyle(
                        fontSize: 38,
                        fontWeight: FontWeight.w900,
                        color: Color(0xFF2F49D1),
                      ),
                    ),

                    const SizedBox(height: 10),

                    const Text(
                      'Kuis seru sedang disiapkan...',
                      style: TextStyle(
                        fontSize: 21,
                        fontWeight: FontWeight.w700,
                        color: Colors.black87,
                      ),
                    ),

                    const SizedBox(height: 30),

                    SizedBox(
                      width: isWide ? 560 : 360,
                      height: isWide ? 370 : 300,
                      child: Stack(
                        alignment: Alignment.center,
                        children: [
                          _shapeCharacter(
                            left: isWide ? 35 : 15,
                            top: isWide ? 105 - (move * 18) : 85 - (move * 14),
                            color: const Color(0xFF3D7BFF),
                            icon: Icons.calculate_rounded,
                            label: '+',
                            size: isWide ? 120 : 88,
                          ),

                          _shapeCharacter(
                            left: isWide ? 200 : 125,
                            top: isWide ? 30 + (move * 16) : 35 + (move * 12),
                            color: const Color(0xFFFFC928),
                            icon: Icons.star_rounded,
                            label: '×',
                            size: isWide ? 155 : 115,
                          ),

                          _shapeCharacter(
                            left: isWide ? 380 : 235,
                            top: isWide ? 105 - (move * 15) : 85 - (move * 10),
                            color: const Color(0xFFFF8A35),
                            icon: Icons.circle,
                            label: '÷',
                            size: isWide ? 125 : 92,
                          ),

                          _shapeCharacter(
                            left: isWide ? 135 : 80,
                            top: isWide ? 235 + (move * 13) : 185 + (move * 10),
                            color: const Color(0xFF2FE0BF),
                            icon: Icons.crop_square_rounded,
                            label: '=',
                            size: isWide ? 130 : 98,
                          ),

                          _shapeCharacter(
                            left: isWide ? 335 : 215,
                            top: isWide ? 225 + (move * 18) : 180 + (move * 14),
                            color: const Color(0xFF9B6BFF),
                            icon: Icons.change_history_rounded,
                            label: '-',
                            size: isWide ? 140 : 105,
                          ),
                        ],
                      ),
                    ),

                    const SizedBox(height: 20),

                    Container(
                      width: isWide ? 360 : 260,
                      height: 26,
                      decoration: BoxDecoration(
                        color: Colors.white,
                        borderRadius: BorderRadius.circular(30),
                        border: Border.all(
                          color: const Color(0xFFFF9F1C),
                          width: 3,
                        ),
                      ),
                      child: ClipRRect(
                        borderRadius: BorderRadius.circular(30),
                        child: AnimatedBuilder(
                          animation: _progressController,
                          builder: (context, _) {
                            return LinearProgressIndicator(
                              value: _progressController.value,
                              backgroundColor: Colors.white,
                              valueColor: const AlwaysStoppedAnimation(
                                Color(0xFFFFC928),
                              ),
                            );
                          },
                        ),
                      ),
                    ),

                    const SizedBox(height: 14),

                    const Text(
                      'Tunggu sebentar ya...',
                      style: TextStyle(
                        fontSize: 17,
                        fontWeight: FontWeight.w700,
                        color: Colors.black87,
                      ),
                    ),
                  ],
                ),
              ),
            );
          },
        ),
      ),
    );
  }

  Widget _shapeCharacter({
    required double left,
    required double top,
    required Color color,
    required IconData icon,
    required String label,
    required double size,
  }) {
    return Positioned(
      left: left,
      top: top,
      child: Stack(
        alignment: Alignment.center,
        children: [
          Icon(
            icon,
            size: size,
            color: color,
          ),

          Positioned(
            top: size * 0.34,
            child: Row(
              mainAxisSize: MainAxisSize.min,
              children: [
                _eye(size),
                SizedBox(width: size * 0.13),
                _eye(size),
              ],
            ),
          ),

          Positioned(
            top: size * 0.52,
            child: Container(
              width: size * 0.30,
              height: size * 0.14,
              decoration: BoxDecoration(
                color: Colors.black,
                borderRadius: BorderRadius.circular(30),
              ),
              child: Center(
                child: Container(
                  width: size * 0.14,
                  height: size * 0.055,
                  decoration: BoxDecoration(
                    color: Colors.pinkAccent,
                    borderRadius: BorderRadius.circular(30),
                  ),
                ),
              ),
            ),
          ),

          Positioned(
            bottom: size * 0.08,
            child: Text(
              label,
              style: TextStyle(
                fontSize: size * 0.28,
                fontWeight: FontWeight.w900,
                color: Colors.white,
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _eye(double size) {
    return Container(
      width: size * 0.09,
      height: size * 0.11,
      decoration: const BoxDecoration(
        color: Colors.black,
        shape: BoxShape.circle,
      ),
    );
  }
}