// Importación de utilidades
import java.util.Scanner; // Para entrada de datos por teclado
import java.util.HashMap; // Para almacenar los animales en una estructura de datos tipo mapa

// Creación de la clase abstracta de la que heredarán Perro y Gato
abstract class Animal {
    // Atributos protegidos (accesibles por las clases hijas)
    protected int Numchip;      // Número de identificación del animal
    protected String nombre;    // Nombre del animal
    protected int edad;         // Edad en años
    protected String raza;      // Raza del animal
    protected boolean adoptado; // Estado de adopción

    // Constructor de la clase Animal
    public Animal(int Numchip, String nombre, int edad, String raza, boolean adoptado) {
        this.Numchip = Numchip;
        this.nombre = nombre;
        this.edad = edad;
        this.raza = raza;
        this.adoptado = adoptado;
    }
    
    // Método abstracto que deberán implementar las clases hijas
    public abstract void mostrar();
}

// Clase Perro que hereda de la clase Animal
class Perro extends Animal {
    // Enumerado para los posibles tamaños de un perro
    protected enum Tamaño {
        PEQUEÑO,
        MEDIANO,
        GRANDE
    }
    
    protected Tamaño tamaño; // Tamaño específico de este perro

    // Constructor de la clase Perro
    public Perro(int Numchip, String nombre, int edad, String raza, boolean adoptado, Tamaño tamaño) {
        // Llama al constructor de la clase padre (Animal)
        super(Numchip, nombre, edad, raza, adoptado);
        this.tamaño = tamaño;
    }
    
    // Implementación del método abstracto mostrar()
    @Override
    public void mostrar() {
        System.out.println("Este perro tiene:\n Numero de chip: " + Numchip + " se llama " + nombre + 
                          " tiene " + edad + " años " + (adoptado ? "Ya esta adoptado" : "No esta adoptado") + 
                          " y es " + tamaño);
    }
}

// Clase Gato que hereda de la clase Animal
class Gato extends Animal {
    protected boolean leucemia; // Indica si el gato tiene leucemia felina

    // Constructor de la clase Gato
    public Gato(int Numchip, String nombre, int edad, String raza, boolean adoptado, boolean leucemia) {
        // Llama al constructor de la clase padre (Animal)
        super(Numchip, nombre, edad, raza, adoptado);
        this.leucemia = leucemia;
    }
    
    // Implementación del método abstracto mostrar()
    @Override
    public void mostrar() {
        System.out.println("Este gato tiene:\n Numero de chip: " + Numchip + " se llama " + nombre + 
                          " tiene " + edad + " años " + "" + leucemia + "tiene leucemia");
    }
}

// Clase Protectora que gestiona los animales
class Protectora {
    // HashMap para almacenar los animales (clave: Numchip, valor: objeto Animal)
    HashMap<Integer, Animal> protectora = new HashMap<>();
    private Scanner scanner = new Scanner(System.in); // Scanner para entrada de datos
    
    // Método para insertar un nuevo animal en la protectora
    public void insertarprotectora() {
        System.out.println("Para insertar un perro escribe 1, para insertar un gato pulse 2");
        int opcion = scanner.nextInt();
        
        if(opcion == 1) { // Insertar perro
            System.out.println("Inserta el Numchip");
            int Numchip = scanner.nextInt();
            scanner.nextLine();
            System.out.println("Inserta el nombre");
            String nombre = scanner.nextLine();
            scanner.nextLine();
            System.out.println("Inserta la edad");
            int edad = scanner.nextInt();
            scanner.nextLine();
            System.out.println("Inserta la raza");
            String raza = scanner.nextLine();
            scanner.nextLine();
            System.out.println("Es adoptado? true/false");
            boolean adoptado = scanner.nextBoolean();
            scanner.nextLine();
            System.out.println("¿Qué tamaño tiene? PEQUEÑO/MEDIANO/GRANDE");
            String t = scanner.nextLine().toUpperCase();
            scanner.nextLine();
            Perro.Tamaño tamaño = Perro.Tamaño.valueOf(t);
            // Añade el nuevo perro al HashMap
            protectora.put(Numchip, new Perro(Numchip, nombre, edad, raza, adoptado, tamaño));
        }
        else if(opcion == 2) { // Insertar gato
            System.out.println("Inserta el Numchip");
            int Numchip = scanner.nextInt();
            scanner.nextLine();
            System.out.println("Inserta el nombre");
            String nombre = scanner.nextLine();
            scanner.nextLine();
            System.out.println("Inserta la edad");
            int edad = scanner.nextInt();
            scanner.nextLine();
            System.out.println("Inserta la raza");
            String raza = scanner.nextLine();
            scanner.nextLine();
            System.out.println("Es adoptado?");
            boolean adoptado = scanner.nextBoolean();
            scanner.nextLine();
            System.out.println("Tiene leucemia");
            boolean leucemia = scanner.nextBoolean();
            scanner.nextLine();
            // Añade el nuevo gato al HashMap
            protectora.put(Numchip, new Gato(Numchip, nombre, edad, raza, adoptado, leucemia));
        }
    }
    
    // Método para buscar un animal por su número de chip
    public void buscarprotectora() {
        System.out.print("Introduce el número de chip: ");
        int Numchip = scanner.nextInt();
        scanner.nextLine();
        
        // Busca el animal en el HashMap
        Animal animal = protectora.get(Numchip);
        if(animal != null) {
            animal.mostrar(); // Muestra la información del animal
        } else {
            System.out.println("No se encontró ningún animal con ese chip.");
        }
    }

    // Método que muestra el menú principal
    public void menu() {
        int opcion;
        do {
            System.out.println("--- MENÚ PROTECTORA ---");
            System.out.println("1. Dar de alta animales");
            System.out.println("2. Buscar animales por número de chip");
            System.out.println("3. Salir");
            System.out.print("Elige una opción: ");
            
            opcion = scanner.nextInt();
            scanner.nextLine();
            
            switch(opcion) {
                case 1:
                    insertarprotectora(); // Alta de animales
                    break;
                case 2:
                    buscarprotectora(); // Búsqueda de animales
                    break;
                case 3:
                    System.out.println("Salir");
                    break;
                default:
                    System.out.println("Opcion incorrecta");
            }
        } while(opcion != 3); // Repite hasta que el usuario elija salir
    }
}

// Clase principal Main que contiene el método main
public class Main {
    public static void main(String[] args) {
        Protectora protectora = new Protectora(); // Crea una instancia de Protectora
        protectora.menu(); // Inicia el menú principal
    }
}