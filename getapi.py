#implementasi kirim json
import requests
#data dinamis
user = str(input("Masukkan nama user: "))
db = str(input("Masukkan nama database: ")) 
#buat endpoint dan datanya
endpoint="http://172.16.12.173:8080/api.php?user="+user+"&Database="+db
#requests get
print(requests.api.get(endpoint).text)
