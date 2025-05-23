import requests
import json
import sys

class PortalKependudukan:
    def __init__(self, host="localhost", user="root", password=""):
        self.host = host
        self.user = user
        self.password = password
        # Sesuaikan dengan path XAMPP Anda
        self.endpoint = "http://localhost/api-mapelsiryoni/quis/portalkependudukan.php"
        self.connect()

    def connect(self):
        """Membuat koneksi ke database"""
        try:
            data = {
                'connect': [self.host, self.user, self.password]
            }
            print(f"\nMencoba koneksi ke database...")
            print(f"Host: {self.host}")
            print(f"User: {self.user}")
            print(f"Endpoint: {self.endpoint}")
            
            response = requests.post(self.endpoint, json=data)
            response.raise_for_status()
            result = response.json()
            
            if result.get('status') == 'success':
                print("\nKoneksi berhasil ke database:", result.get('database'))
                return True
            else:
                print("\nError:", result.get('message'))
                return False
                
        except requests.exceptions.RequestException as e:
            print(f"\nError koneksi: {str(e)}")
            print("Pastikan XAMPP berjalan dan file PHP berada di lokasi yang benar")
            return False
        except Exception as e:
            print(f"\nError tidak terduga: {str(e)}")
            return False

    def input_data(self, data_type):
        """Input data kependudukan atau pegawai"""
        try:
            if data_type == "kependudukan":
                print("\n=== Input Data Kependudukan ===")
                nik = input("Masukkan NIK: ")
                nama = input("Masukkan Nama: ")
                alamat = input("Masukkan Alamat: ")
                
                data = {
                    'type': 'kependudukan',
                    'data': {
                        'nik': nik,
                        'nama': nama,
                        'alamat': alamat
                    }
                }
            elif data_type == "pegawai":
                print("\n=== Input Data Pegawai ===")
                nik = input("Masukkan NIK: ")
                nama = input("Masukkan Nama: ")
                jabatan = input("Masukkan Jabatan: ")
                
                data = {
                    'type': 'pegawai',
                    'data': {
                        'nik': nik,
                        'nama': nama,
                        'jabatan': jabatan
                    }
                }
            else:
                print("Tipe data tidak valid!")
                return False

            print(f"\nMengirim data ke {self.endpoint}...")
            response = requests.post(self.endpoint, json=data)
            response.raise_for_status()
            result = response.json()
            
            if result.get('status') == 'success':
                print("\nData berhasil disimpan!")
                return True
            else:
                print("\nError:", result.get('message'))
                return False
                
        except requests.exceptions.RequestException as e:
            print(f"\nError koneksi: {str(e)}")
            print("Pastikan XAMPP berjalan dan file PHP berada di lokasi yang benar")
            return False
        except Exception as e:
            print(f"\nError tidak terduga: {str(e)}")
            return False

    def get_data(self, data_type):
        """Mengambil data dari database"""
        try:
            data = {
                'type': 'get_data',
                'table': data_type
            }
            
            print(f"\nMengambil data dari {self.endpoint}...")
            response = requests.post(self.endpoint, json=data)
            response.raise_for_status()
            result = response.json()
            
            if result.get('status') == 'success':
                return result.get('data', [])
            else:
                print("\nError:", result.get('message'))
                return []
                
        except requests.exceptions.RequestException as e:
            print(f"\nError koneksi: {str(e)}")
            print("Pastikan XAMPP berjalan dan file PHP berada di lokasi yang benar")
            return []
        except Exception as e:
            print(f"\nError tidak terduga: {str(e)}")
            return []

    def display_data(self, data_type):
        """Menampilkan data dalam format tabel"""
        data = self.get_data(data_type)
        
        if not data:
            print(f"\nTidak ada data {data_type} yang tersimpan.")
            return
        
        if data_type == "kependudukan":
            headers = ["NIK", "Nama", "Alamat"]
            # Tentukan lebar kolom
            widths = [15, 20, 40]
        else:  # pegawai
            headers = ["NIK", "Nama", "Jabatan"]
            widths = [15, 20, 20]
            
        print(f"\n=== Data {data_type.upper()} ===")
        
        # Buat garis pemisah
        separator = "+" + "+".join("-" * width for width in widths) + "+"
        
        # Tampilkan header
        print(separator)
        header = "|"
        for i, header_text in enumerate(headers):
            header += f" {header_text:<{widths[i]-1}}|"
        print(header)
        print(separator)
        
        # Tampilkan data
        for row in data:
            line = "|"
            if data_type == "kependudukan":
                line += f" {row['NIK']:<{widths[0]-1}}|"
                line += f" {row['NAMA']:<{widths[1]-1}}|"
                line += f" {row['ALAMAT']:<{widths[2]-1}}|"
            else:
                line += f" {row['NIK']:<{widths[0]-1}}|"
                line += f" {row['NAMA']:<{widths[1]-1}}|"
                line += f" {row['JABATAN']:<{widths[2]-1}}|"
            print(line)
        
        print(separator)

def main():
    print("\n=== Portal Kependudukan ===")
    print("Pastikan XAMPP sudah berjalan!")
    print("File PHP harus berada di: C:/xampp/htdocs/api-mapelsiryoni/quis/portalkependudukan.php")
    input("Tekan Enter untuk melanjutkan...")
    
    # Inisialisasi koneksi
    portal = PortalKependudukan()
    
    while True:
        print("\n=== Portal Kependudukan ===")
        print("1. Input Data Kependudukan")
        print("2. Input Data Pegawai")
        print("3. Lihat Data Kependudukan")
        print("4. Lihat Data Pegawai")
        print("5. Keluar")
        
        choice = input("\nPilih menu (1-5): ")
        
        if choice == "1":
            portal.input_data("kependudukan")
        elif choice == "2":
            portal.input_data("pegawai")
        elif choice == "3":
            portal.display_data("kependudukan")
        elif choice == "4":
            portal.display_data("pegawai")
        elif choice == "5":
            print("\nTerima kasih telah menggunakan Portal Kependudukan!")
            sys.exit(0)
        else:
            print("\nPilihan tidak valid!")

if __name__ == "__main__":
    try:
        main()
    except KeyboardInterrupt:
        print("\n\nProgram dihentikan oleh user.")
        sys.exit(0)
    except Exception as e:
        print(f"\nError tidak terduga: {str(e)}")
        sys.exit(1)
