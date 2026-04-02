import 'package:flutter/material.dart';

class AuthBackground extends StatelessWidget {
  final Widget child;
  const AuthBackground({super.key, required this.child});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Stack(
        children: [
          Column(
            children: [
              Expanded(flex: 6, child: Container(color: const Color(0xFFBFD0FF))),
              Expanded(flex: 4, child: Container(color: const Color(0xFFFFF7E5))),
            ],
          ),
          Positioned(left: -60, top: 160, child: _ringBubble()),
          Positioned(right: -30, top: 40, child: _bubbleCluster()),
          Positioned(right: -30, bottom: 90, child: _bubbleCluster()),
          SafeArea(child: child),
        ],
      ),
    );
  }

  Widget _ringBubble() {
    return Stack(
      alignment: Alignment.center,
      children: [
        Container(width: 150, height: 150, decoration: const BoxDecoration(shape: BoxShape.circle, color: Colors.white)),
        Container(width: 120, height: 120, decoration: const BoxDecoration(shape: BoxShape.circle, color: Color(0xFF9B8CFF))),
        Positioned(
          right: 6, bottom: 12,
          child: Container(width: 16, height: 16, decoration: const BoxDecoration(shape: BoxShape.circle, color: Color(0xFFFF4D4D))),
        ),
        Positioned(
          right: 32, top: 14,
          child: Container(width: 26, height: 26, decoration: const BoxDecoration(shape: BoxShape.circle, color: Color(0xFF93FF9A))),
        ),
      ],
    );
  }

  Widget _bubbleCluster() {
    return Stack(
      alignment: Alignment.center,
      children: [
        Container(width: 120, height: 120, decoration: const BoxDecoration(shape: BoxShape.circle, color: Colors.white)),
        Container(width: 92, height: 92, decoration: const BoxDecoration(shape: BoxShape.circle, color: Color(0xFF9B8CFF))),
        Positioned(
          right: 4, top: 28,
          child: Container(width: 20, height: 20, decoration: const BoxDecoration(shape: BoxShape.circle, color: Color(0xFF93FF9A))),
        ),
        Positioned(
          right: 10, bottom: 16,
          child: Container(width: 14, height: 14, decoration: const BoxDecoration(shape: BoxShape.circle, color: Color(0xFFFF4D4D))),
        ),
      ],
    );
  }
}
