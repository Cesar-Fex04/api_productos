import requests

def main():
    codigo = input("Escribe el código del producto a buscar: ").strip()

    url = f"http://localhost/apis/buscar_producto.php?codigo={codigo}"
    print(f"Consultando: {url}")

    try:
        response = requests.get(url)
        print(f"Código de respuesta HTTP: {response.status_code}")
        print("Respuesta del servidor:")
        print(response.json())
    except requests.exceptions.RequestException as e:
        print("Error al conectarse con la API:")
        print(e)
    except ValueError:
        print("La respuesta no es un JSON válido.")

if __name__ == "__main__":
    main()
# ejecutar el script
# python test_api.py