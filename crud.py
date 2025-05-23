import requests
#input kependudukan
#data dinamis
user = str(input("Masukkan NIK : "))
db = str(input("Masukkan NAMA: ")) 
user = str(input("Masukkan ALAMAT: "))

Data={'connect' : ["127.0.0.1", "root","", "db"]}
endpoint="http://172.16.10.105:8080/portalkependudukan.php"
#requests get
print(requests.api.post(endpoint,Data))