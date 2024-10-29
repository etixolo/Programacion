while True: #bucle para comprobar que el saldo introducido es positivo
    saldo = float(input("Introduce el saldo inicial de la cuenta: "))
    if saldo >= 0:
        break
    else:
        print("El saldo no puede ser negativo. Por favor intenta de nuevo.")
#un menu para las opciones
while True: 
    print("\nMenú:")
    print("1 - Ingresar dinero")
    print("2 - Retirar dinero")
    print("3 - Mostrar saldo")
    print("4 - Salir")
    #pregunta la opcion al usuario
    opcion = input("Selecciona una opción: ")
    #revisa que opcion a escogido y realiza la operacion 
    if opcion == '1':
        cantidad = float(input("¿Cuánto deseas ingresar? "))
        if cantidad >= 0:
            saldo += cantidad #suma la cantidad dada al saldo de la cuenta
            print(f"Has ingresado {cantidad}. Nuevo saldo: {saldo}.")
        else:
            print("No puedes ingresar cantidades negativas.")
    
    elif opcion == '2':
        cantidad = float(input("¿Cuánto deseas retirar? "))
        if cantidad >= 0:
            if saldo - cantidad >= 0:
                saldo -= cantidad #resta la cantidad dada al saldo de la cuenta
                print(f"Has retirado {cantidad}. Nuevo saldo: {saldo}.")
            else:
                print("No puedes retirar más de lo que tienes en la cuenta.") #si no puedes retirar tanto o es negativo salta ese error
        else:
            print("No puedes retirar cantidades negativas.")
    
    elif opcion == '3':
        print(f"Saldo actual: {saldo}.")#muestra el saldo de la cuenta
    
    elif opcion == '4':
        print("Saliendo...")#sale del programa
        break
    
    else:
        print("Opción no válida, por favor intenta de nuevo.") #si no eliges ninguna de las opciones dadas
