import java.util.Scanner;
import java.util.HashMap;
import java.util.ArrayList;

// Clase base para todos los animales
abstract class Animal {
    protected int Numchip;
    protected String nombre;
    protected int edad;
    protected String raza;
    protected boolean adoptado;

    public Animal(int Numchip, String nombre, int edad, String raza, boolean adoptado) {
        this.Numchip = Numchip;
        this.nombre = nombre;
        this.edad = edad;
        this.raza = raza;
        this.adoptado = adoptado;
    }

    public abstract void mostrar();
}

// Clase Perro con atributo adicional de tamaño
class Perro extends Animal {
    protected enum Tamaño { PEQUEÑO, MEDIANO, GRANDE }

    protected Tamaño tamaño;

    public Perro(int Numchip, String nombre, int edad, String raza, boolean adoptado, Tamaño tamaño) {
        super(Numchip, nombre, edad, raza, adoptado);
        this.tamaño = tamaño;
    }

    @Override
    public void mostrar() {
        System.out.println("Este perro tiene:\n Numero de chip: " + Numchip + " se llama " + nombre +
                         " tiene " + edad + " años " + (adoptado ? "Ya está adoptado" : "No está adoptado") +
                         " y es " + tamaño);
    }
}

// Clase Gato con atributo leucemia
class Gato extends Animal {
    protected boolean leucemia;

    public Gato(int Numchip, String nombre, int edad, String raza, boolean adoptado, boolean leucemia) {
        super(Numchip, nombre, edad, raza, adoptado);
        this.leucemia = leucemia;
    }

    @Override
    public void mostrar() {
        System.out.println("Este gato tiene:\n Numero de chip: " + Numchip + " se llama " + nombre +
                         " tiene " + edad + " años y " + (leucemia ? "tiene leucemia" : "no tiene leucemia"));
    }
}

// Info sobre una adopción
class Adopcion {
    private int numChip;
    private String nombreAdoptante;
    private String dniAdoptante;

    public Adopcion(int numChip, String nombreAdoptante, String dniAdoptante) {
        this.numChip = numChip;
        this.nombreAdoptante = nombreAdoptante;
        this.dniAdoptante = dniAdoptante;
    }

    public int getNumChip() { return numChip; }
    public String getNombreAdoptante() { return nombreAdoptante; }
    public String getDniAdoptante() { return dniAdoptante; }
}

// Gestión de animales y adopciones
class Protectora {
    HashMap<Integer, Animal> protectora = new HashMap<>();
    ArrayList<Adopcion> adopciones = new ArrayList<>();
    private Scanner scanner = new Scanner(System.in);

    // Añadir nuevo animal
    public void insertarprotectora() {
        System.out.println("Para insertar un perro escribe 1, para insertar un gato pulse 2");
        int opcion = scanner.nextInt();

        if(opcion == 1) {
            System.out.println("Inserta el Numchip");
            int Numchip = scanner.nextInt();
            scanner.nextLine();

            System.out.println("Inserta el nombre");
            String nombre = scanner.nextLine();

            System.out.println("Inserta la edad");
            int edad = scanner.nextInt();
            scanner.nextLine();

            System.out.println("Inserta la raza");
            String raza = scanner.nextLine();

            System.out.println("¿Es adoptado? true/false");
            boolean adoptado = scanner.nextBoolean();
            scanner.nextLine();

            System.out.println("¿Qué tamaño tiene? PEQUEÑO/MEDIANO/GRANDE");
            String t = scanner.nextLine().toUpperCase();
            Perro.Tamaño tamaño = Perro.Tamaño.valueOf(t);

            protectora.put(Numchip, new Perro(Numchip, nombre, edad, raza, adoptado, tamaño));
        }
        else if(opcion == 2) {
            System.out.println("Inserta el Numchip");
            int Numchip = scanner.nextInt();
            scanner.nextLine();

            System.out.println("Inserta el nombre");
            String nombre = scanner.nextLine();

            System.out.println("Inserta la edad");
            int edad = scanner.nextInt();
            scanner.nextLine();

            System.out.println("Inserta la raza");
            String raza = scanner.nextLine();

            System.out.println("¿Es adoptado? true/false");
            boolean adoptado = scanner.nextBoolean();
            scanner.nextLine();

            System.out.println("¿Tiene leucemia? true/false");
            boolean leucemia = scanner.nextBoolean();
            scanner.nextLine();

            protectora.put(Numchip, new Gato(Numchip, nombre, edad, raza, adoptado, leucemia));
        }
    }

    // Lista todos los animales
    public void listarAnimales() {
        if (protectora.isEmpty()) {
            System.out.println("No hay animales registrados.");
            return;
        }

        for (Animal animal : protectora.values()) {
            animal.mostrar();
            System.out.println("-------------------");
        }
    }

    // Busca animal por chip
    public void buscarAnimal() {
        System.out.print("Introduce el número de chip: ");
        try {
            int Numchip = scanner.nextInt();
            scanner.nextLine();

            Animal animal = protectora.get(Numchip);
            if (animal != null) {
                animal.mostrar();
            } else {
                System.out.println("No se encontró ningún animal con ese chip.");
            }
        } catch (Exception e) {
            System.out.println("Error: Debes introducir un número válido.");
            scanner.nextLine();
        }
    }

    // Registra una adopción
    public void realizarAdopcion() {
        try {
            System.out.print("Introduce el número de chip del animal: ");
            int numChip = scanner.nextInt();
            scanner.nextLine();

            Animal animal = protectora.get(numChip);
            if (animal == null) {
                System.out.println("No existe animal con ese chip.");
                return;
            }

            if (animal.adoptado) {
                System.out.println("Este animal ya está adoptado.");
                return;
            }

            System.out.print("Nombre del adoptante: ");
            String nombre = scanner.nextLine();

            System.out.print("DNI del adoptante: ");
            String dni = scanner.nextLine();

            Animal nuevoAnimal;
            if (animal instanceof Perro) {
                Perro p = (Perro)animal;
                nuevoAnimal = new Perro(p.Numchip, p.nombre, p.edad, p.raza, true, p.tamaño);
            } else {
                Gato g = (Gato)animal;
                nuevoAnimal = new Gato(g.Numchip, g.nombre, g.edad, g.raza, true, g.leucemia);
            }

            protectora.put(numChip, nuevoAnimal);
            adopciones.add(new Adopcion(numChip, nombre, dni));
            System.out.println("Adopción registrada correctamente.");
        } catch (Exception e) {
            System.out.println("Error en los datos introducidos.");
            scanner.nextLine();
        }
    }

    // Dar de baja un animal por chip
    public void darDeBaja() {
        try {
            System.out.print("Introduce número de chip: ");
            int numChip = scanner.nextInt();
            scanner.nextLine();

            if (!protectora.containsKey(numChip)) {
                System.out.println("No existe animal con ese chip.");
                return;
            }

            // Borra adopción si existe
            for (int i = 0; i < adopciones.size(); i++) {
                if (adopciones.get(i).getNumChip() == numChip) {
                    adopciones.remove(i);
                    break;
                }
            }

            protectora.remove(numChip);
            System.out.println("Animal dado de baja correctamente.");
        } catch (Exception e) {
            System.out.println("Error en los datos introducidos.");
            scanner.nextLine();
        }
    }

    // Muestra total de gatos y cuántos tienen leucemia
    public void mostrarEstadisticasGatos() {
        int totalGatos = 0;
        int conLeucemia = 0;

        for (Animal animal : protectora.values()) {
            if (animal instanceof Gato) {
                totalGatos++;
                Gato g = (Gato)animal;
                if (g.leucemia) conLeucemia++;
            }
        }

        System.out.println("Total de gatos: " + totalGatos);
        System.out.println("Gatos con leucemia: " + conLeucemia);
    }

    // Menú principal
    public void menu() {
        int opcion;
        do {
            System.out.println("\nMENÚ PROTECTORA DE ANIMALES");
            System.out.println("1. Dar de alta animales");
            System.out.println("2. Listar animales");
            System.out.println("3. Buscar animal por chip");
            System.out.println("4. Realizar adopción");
            System.out.println("5. Dar de baja animal");
            System.out.println("6. Mostrar estadísticas de gatos");
            System.out.println("7. Salir");
            System.out.print("Elige una opción: ");

            try {
                opcion = scanner.nextInt();
                scanner.nextLine();

                switch(opcion) {
                    case 1: insertarprotectora(); break;
                    case 2: listarAnimales(); break;
                    case 3: buscarAnimal(); break;
                    case 4: realizarAdopcion(); break;
                    case 5: darDeBaja(); break;
                    case 6: mostrarEstadisticasGatos(); break;
                    case 7: System.out.println("Saliendo del sistema..."); break;
                    default: System.out.println("Opción no válida");
                }
            } catch (Exception e) {
                System.out.println("Error: Introduce un número del 1 al 7");
                scanner.nextLine();
                opcion = 0;
            }
        } while(opcion != 7);
    }
}

// Clase principal
public class Main {
    public static void main(String[] args) {
        Protectora protectora = new Protectora();
        protectora.menu();
    }
}
