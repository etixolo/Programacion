#Bucle infinito que muestra un menú hasta que el usuario decida salir
#Menu que pide al usuario que ingrese una opcion
while True:
    print("\nMenú:")
    print("1 - Cuadrado")
    print("2 - Rectángulo")
    print("3 - Salir")
    
    opcion = input("Selecciona una opción: ")
    #Lee la opcion y aplica las formulas para un cuadrado
    if opcion == '1':
        lado = float(input("Introduce la longitud del lado del cuadrado: "))
        area = lado ** 2
        perimetro = 4 * lado
        print("\nCuadrado:")
        print("Área:", area)
        print("Perímetro:", perimetro)
        for _ in range(int(lado)):
            print("* " * int(lado))#Enseña un cuadrado con las dimensiones elegidas
    
    #Lee la opcion y aplica las formulas para un rectangulo
    elif opcion == '2':
        base = float(input("Introduce la base del rectángulo: "))
        altura = float(input("Introduce la altura del rectángulo: "))
        area = base * altura
        perimetro = 2 * (base + altura)
        print("\nRectángulo:")
        print("Área:", area)
        print("Perímetro:", perimetro)
        for _ in range(int(altura)):
            print("* " * int(base))#Enseña un rectangulo con las dimensiones elegidas
    
    #Una tercera opcion para parar el bucle
    elif opcion == '3':
        print("Saliendo...")
        break
    
    else:
        print("Opción no válida, por favor intenta de nuevo.")#Por si no elige ninguna de las opciones


