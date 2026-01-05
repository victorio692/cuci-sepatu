#!/usr/bin/env python3
"""
Script untuk membuat logo SYH Cleaning
Run: python create_logo.py
"""

from PIL import Image, ImageDraw, ImageFont
import os

# Create directory if not exists
output_dir = 'public/assets/images'
if not os.path.exists(output_dir):
    os.makedirs(output_dir)

# Create a new image with white background
width = 200
height = 200
img = Image.new('RGB', (width, height), 'white')
draw = ImageDraw.Draw(img)

# Draw circle border
border_color = '#1f2937'
draw.ellipse([5, 5, 195, 195], outline=border_color, width=3)

# Draw text (SYH.CLEANING)
try:
    # Try to use a better font if available
    font = ImageFont.truetype("arial.ttf", 18)
except:
    font = ImageFont.load_default()

text = "SYH.CLEANING"
bbox = draw.textbbox((0, 0), text, font=font)
text_width = bbox[2] - bbox[0]
text_x = (width - text_width) // 2
draw.text((text_x, 150), text, fill=border_color, font=font)

# Draw shoe icon (simple representation)
shoe_color = '#f3f4f6'
border = '#1f2937'
# Left shoe
draw.ellipse([40, 50, 70, 85], fill=shoe_color, outline=border, width=2)
draw.line([40, 75, 70, 75], fill=border, width=2)

# Right shoe
draw.ellipse([80, 50, 110, 85], fill=shoe_color, outline=border, width=2)
draw.line([80, 75, 110, 75], fill=border, width=2)

# Star
star_x, star_y = 120, 60
draw.polygon([
    (star_x, star_y-8),
    (star_x+3, star_y-2),
    (star_x+9, star_y-2),
    (star_x+4, star_y+2),
    (star_x+6, star_y+8),
    (star_x, star_y+4),
    (star_x-6, star_y+8),
    (star_x-4, star_y+2),
    (star_x-9, star_y-2),
    (star_x-3, star_y-2)
], fill='#3b82f6', outline='#1f2937')

# Save image
output_path = os.path.join(output_dir, 'logo.png')
img.save(output_path, 'PNG')
print(f"Logo created successfully: {output_path}")
