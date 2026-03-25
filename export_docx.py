import base64
import zlib
import re
import subprocess
import os

def kroki_mermaid_url(text):
    compressed = zlib.compress(text.encode('utf-8'), 9)
    encoded = base64.urlsafe_b64encode(compressed).decode('utf-8')
    return f"https://kroki.io/mermaid/png/{encoded}"

input_file = '/home/moriarty/.gemini/antigravity/brain/e682b538-705b-4b6c-8312-c957ee6b8045/walkthrough.md'
output_docx = '/home/moriarty/Documents/yssc-web-laravel/YSSC_Feature_Summary.docx'

with open(input_file, 'r') as f:
    md_content = f.read()

pattern = re.compile(r'```mermaid\s*\n(.*?\n)```', re.DOTALL)
matches = pattern.finditer(md_content)

processed_md = md_content
for i, match in enumerate(matches):
    block_text = match.group(0)
    mermaid_code = match.group(1)
    url = kroki_mermaid_url(mermaid_code)
    img_path = f"/tmp/diag_{i}.png"
    print(f"Downloading {img_path} via curl...")
    res = subprocess.run(['curl', '-s', '-L', '-A', 'Mozilla/5.0', '-o', img_path, url])
    if res.returncode == 0 and os.path.exists(img_path):
        processed_md = processed_md.replace(block_text, f'![Diagram {i}]({img_path})')
    else:
        print(f"Failed to fetch image {i}")

processed_path = '/tmp/processed_walkthrough.md'
with open(processed_path, 'w') as f:
    f.write(processed_md)

print("Running pandoc...")
pandoc_bin = '/home/moriarty/Documents/yssc-web-laravel/pandoc-3.1.12.2/bin/pandoc'
res = subprocess.run([pandoc_bin, processed_path, '-o', output_docx])
if res.returncode == 0:
    print(f"Successfully created DOCX at {output_docx}!")
else:
    print("Pandoc failed.")
