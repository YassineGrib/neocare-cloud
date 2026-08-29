import sys
import os

if sys.platform == 'win32':
    for p in [r"C:\src\windows-msvc2022_64-cl\bin", r"C:\src\windows-msvc2022_64-cl\dev-utils\bin"]:
        if os.path.exists(p):
            os.add_dll_directory(p)
            os.environ['PATH'] = p + ';' + os.environ['PATH']

import argparse
import cairosvg

def main():
    parser = argparse.ArgumentParser(description="SVG to PNG converter shim for CMake", add_help=False)
    parser.add_argument('-w', '--width', type=int, help='Width')
    parser.add_argument('-h', '--height', type=int, help='Height')
    parser.add_argument('-o', '--output', type=str, help='Output PNG file')
    parser.add_argument('input', nargs='?', type=str, help='Input SVG file')
    
    args, unknown = parser.parse_known_args()
    
    input_file = args.input
    output_file = args.output
    
    # Handle positional or unknown arguments if any
    if not input_file and unknown:
        for u in unknown:
            if not u.startswith('-') and (u.endswith('.svg') or os.path.exists(u)):
                input_file = u
                break
                
    if not output_file and unknown:
        if '-o' in unknown:
            idx = unknown.index('-o')
            if idx + 1 < len(unknown):
                output_file = unknown[idx + 1]

    if not input_file:
        print("Error: No input SVG file provided", file=sys.stderr)
        sys.exit(1)
        
    width = args.width
    height = args.height
    
    print(f"[SVG Converter Shim] Converting {input_file} -> {output_file} (size: {width}x{height})")
    with open(input_file, 'rb') as svg_f:
        svg_data = svg_f.read()
    cairosvg.svg2png(bytestring=svg_data, write_to=output_file, output_width=width, output_height=height)
    print(f"[SVG Converter Shim] Successfully generated {output_file}")

if __name__ == '__main__':
    main()
