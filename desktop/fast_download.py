import os
import sys
import time
import urllib.request
from concurrent.futures import ThreadPoolExecutor, as_completed

USER_AGENT = 'Wget/1.21'

def get_file_size(url):
    req = urllib.request.Request(url, headers={'User-Agent': USER_AGENT})
    with urllib.request.urlopen(req, timeout=30) as resp:
        return int(resp.headers.get('Content-Length', 0))

def download_chunk(url, start_byte, end_byte, part_filename):
    expected_total = end_byte - start_byte + 1
    max_retries = 20
    
    for attempt in range(max_retries):
        current_len = os.path.getsize(part_filename) if os.path.exists(part_filename) else 0
        if current_len == expected_total:
            return True
        if current_len > expected_total:
            os.remove(part_filename)
            current_len = 0
            
        chunk_start = start_byte + current_len
        headers = {
            'User-Agent': USER_AGENT,
            'Range': f'bytes={chunk_start}-{end_byte}'
        }
        req = urllib.request.Request(url, headers=headers)
        try:
            with urllib.request.urlopen(req, timeout=30) as resp:
                with open(part_filename, 'ab') as f:
                    while True:
                        buf = resp.read(512 * 1024)
                        if not buf:
                            break
                        f.write(buf)
            if os.path.getsize(part_filename) == expected_total:
                return True
        except Exception as e:
            if attempt == max_retries - 1:
                print(f"Failed chunk {start_byte}-{end_byte}: {e}", flush=True)
                raise
            time.sleep(1)

def fast_download(url, output_path, num_threads=24):
    os.makedirs(os.path.dirname(output_path), exist_ok=True)
    
    total_size = get_file_size(url)
    print(f"Target: {os.path.basename(output_path)} ({total_size / (1024*1024):.2f} MB) with {num_threads} threads and resumable chunks...", flush=True)
    
    chunk_size = total_size // num_threads
    tasks = []
    part_files = []
    
    start_time = time.time()
    with ThreadPoolExecutor(max_workers=num_threads) as executor:
        for i in range(num_threads):
            start_byte = i * chunk_size
            end_byte = (i + 1) * chunk_size - 1 if i < num_threads - 1 else total_size - 1
            part_filename = f"{output_path}.part{i}"
            part_files.append(part_filename)
            tasks.append(executor.submit(download_chunk, url, start_byte, end_byte, part_filename))
        
        done = 0
        for future in as_completed(tasks):
            future.result()
            done += 1
            elapsed = time.time() - start_time
            print(f"Completed {done}/{num_threads} chunks ({done*100//num_threads}%) in {elapsed:.1f}s", flush=True)
            
    print("Stitching parts together...", flush=True)
    with open(output_path, 'wb') as out_f:
        for part in part_files:
            with open(part, 'rb') as in_f:
                while True:
                    buf = in_f.read(8 * 1024 * 1024)
                    if not buf:
                        break
                    out_f.write(buf)
            try:
                os.remove(part)
            except Exception:
                pass
            
    final_size = os.path.getsize(output_path)
    print(f"Downloaded successfully: {output_path} ({final_size} bytes, matches {total_size} -> {final_size == total_size}) in {time.time() - start_time:.1f}s", flush=True)

if __name__ == '__main__':
    url = sys.argv[1]
    output_path = sys.argv[2]
    threads = int(sys.argv[3]) if len(sys.argv) > 3 else 24
    fast_download(url, output_path, threads)
