import requests as www

print('1. Setup Database')
menu = int(input("Pilih menu: "))

if menu == 1:
    # buat endpoint
    endpoint = "http://localhost/belajarAPI.php"  # alamat api
    
    # buat json
    data = {'setup': True}
    
    try:
        # request
        response = www.post(endpoint, data)
        
        # cek status response
        if response.ok:
            print("Berhasil setup database!")
            print("Response:", response.text)
        else:
            print("Gagal setup database!")
            print("Status code:", response.status_code)
            print("Response:", response.text)
            
    except requests.exceptions.RequestException as e:
        print("Error:", e)