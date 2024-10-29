import random #importamos la librea random para que elija un numero random

#numero de intentos de cada uno el bot y el usuario
contador_usuario = 0
contador_maquina = 0
#un contador para que si ninguno supera las derrotas o las victorias siga el bucle
while contador_usuario < 3 and contador_maquina < 3: 
    print("\nMenú:")
    print("1 - Piedra")
    print("2 - Papel")
    print("3 - Tijera")
    
    opcion_usuario = input("Selecciona una opción: ")
    #por si el usuario no escribe una opcion valida
    if opcion_usuario not in ['1', '2', '3']:
        print("Opción no válida, por favor intenta de nuevo.")
        continue#para volver al principio del bucle
    
    opcion_maquina = str(random.randint(1, 3))
    opciones = { '1': 'Piedra', '2': 'Papel', '3': 'Tijera' }
    #las opciones de ambos
    print(f"\nTú elegiste: {opciones[opcion_usuario]}")
    print(f"El bot eligió: {opciones[opcion_maquina]}")
    #los condicionales para saber quien a ganado 
    if opcion_usuario == opcion_maquina:
        print("¡Es un empate!")
    elif (opcion_usuario == '1' and opcion_maquina == '3') or \
            (opcion_usuario == '2' and opcion_maquina == '1') or \
            (opcion_usuario == '3' and opcion_maquina == '2'):
        print("¡Ganaste!")
        contador_usuario += 1 #suma una victoria al usuario
    else:
        print("Perdiste.")
        contador_maquina += 1 #suma una victoria al bot
    
