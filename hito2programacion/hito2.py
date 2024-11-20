import uuid

# Base de datos simulada
clientes = {}
productos = {
    "001": {"nombre": "Producto A", "precio": 10.0},
    "002": {"nombre": "Producto B", "precio": 20.0},
    "003": {"nombre": "Producto C", "precio": 30.0},
}
pedidos = {}

# Función para registrar un cliente
def registrar_cliente():
    correo = input("Ingrese el correo electrónico del cliente: ")
    if correo in clientes:
        print("Error: El cliente ya está registrado.")
        return
    nombre = input("Ingrese el nombre del cliente: ")
    telefono = input("Ingrese el teléfono del cliente: ")
    clientes[correo] = {"nombre": nombre, "telefono": telefono}
    print("Registro exitoso.")

# Función para mostrar clientes
def mostrar_clientes():
    if not clientes:
        print("No hay clientes registrados.")
        return
    for correo, datos in clientes.items():
        print(f"Correo: {correo}, Nombre: {datos['nombre']}, Teléfono: {datos['telefono']}")

# Función para realizar una compra
def realizar_compra():
    correo = input("Ingrese el correo del cliente: ")
    if correo not in clientes:
        print("Error: Cliente no registrado.")
        return
    print("Productos disponibles:")
    for codigo, info in productos.items():
        print(f"{codigo}: {info['nombre']} - ${info['precio']}")
    seleccion = input("Ingrese los códigos de los productos a comprar (separados por coma): ")
    codigos = seleccion.split(",")
    total = 0
    items = []
    for codigo in codigos:
        if codigo.strip() in productos:
            items.append(productos[codigo.strip()])
            total += productos[codigo.strip()]["precio"]
    if not items:
        print("No se seleccionaron productos válidos.")
        return
    numero_pedido = str(uuid.uuid4())[:8]
    pedidos[numero_pedido] = {"cliente": correo, "productos": items, "total": total}
    print(f"Compra realizada con éxito. Número de pedido: {numero_pedido}")

# Función para seguir un pedido
def seguimiento_pedido():
    numero_pedido = input("Ingrese el número del pedido: ")
    if numero_pedido not in pedidos:
        print("Pedido no encontrado.")
        return
    pedido = pedidos[numero_pedido]
    cliente = clientes[pedido["cliente"]]
    print(f"Cliente: {cliente['nombre']} ({cliente['telefono']})")
    print("Productos:")
    for producto in pedido["productos"]:
        print(f"- {producto['nombre']} - ${producto['precio']}")
    print(f"Total: ${pedido['total']}")

# Menú principal
def menu():
    while True:
        print("\nMenú Principal:")
        print("1. Registrar cliente")
        print("2. Mostrar clientes")
        print("3. Realizar compra")
        print("4. Seguimiento de pedido")
        print("5. Salir")
        opcion = input("Seleccione una opción: ")
        if opcion == "1":
            registrar_cliente()
        elif opcion == "2":
            mostrar_clientes()
        elif opcion == "3":
            realizar_compra()
        elif opcion == "4":
            seguimiento_pedido()
        elif opcion == "5":
            print("¡Hasta luego!")
            break
        else:
            print("Opción no válida.")

# Ejecutar el programa
menu()
