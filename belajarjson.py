#python
#json
import requests;
#buat dara json
nama=str(input("masukkan nama: "))
usia=int(input("masukkan usia: "))
data = {
    'user':"marin",
    'usia':17,
    'Test':True
}
#kirim data json
Endpoint ="http://172.16.11.117:8080/api.php"
print(requests.api.post(Endpoint,data).text)