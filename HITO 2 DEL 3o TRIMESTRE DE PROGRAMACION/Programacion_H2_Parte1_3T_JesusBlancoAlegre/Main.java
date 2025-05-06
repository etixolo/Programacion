import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.Scanner;

class Menu {

 Scanner scanner = new Scanner(System.in);

//Menu principal
 public void menu() {
     int opcion;
     //While hasta que des 2
     do {
         System.out.println("--- Menú Películas ---");
         System.out.println("1 - Ver películas");
         System.out.println("2 - Salir");

         System.out.print("Seleccione una opción: ");
         opcion = scanner.nextInt();
         scanner.nextLine();

         switch (opcion) {
             case 1:
                 verPeliculas();
                 break;
             case 2:
                 System.out.println("Saliendo");
                 break;
             default:
                 System.out.println("Opcion incorrecta");
         }
     } while (opcion != 2);
 }

 
 public void verPeliculas() {
     //Configuracion de la conexion
	 String url = "jdbc:mysql://localhost:3306/cine_JesusBlanco";
     String usuario = "root";
     String contraseña = "1234";
     //Conexion y consulta join
     try (Connection conexion = DriverManager.getConnection(url, usuario, contraseña)) {
         String consulta = "SELECT Peliculas.idpelicula, titulo, duracion, genero, disponibleenNetflix, presupuesto " +
                           "FROM Peliculas INNER JOIN Costes ON Peliculas.idpelicula = Costes.idpelicula";

         Statement stmt = conexion.createStatement();
         ResultSet rs = stmt.executeQuery(consulta);
         //Printf con los datos de la tabla
         System.out.printf("%-5s %-10s %-10s %-10s %-10s %-10s\n",
                 "ID", "Título", "Duración", "Género", "Netflix", "Presupuesto");

         while (rs.next()) {
        	 //imprime la consulta con el formato del printf
             System.out.printf("%-5d %-10s %-10d %-10s %-10b %-10d\n",
                     rs.getInt("idpelicula"),
                     rs.getString("titulo"),
                     rs.getInt("duracion"),
                     rs.getString("genero"),
                     rs.getBoolean("disponibleenNetflix"),
                     rs.getInt("presupuesto"));
         }
         //cierre procesos
         rs.close();
         stmt.close();
    //try catch por si falla la conexion
    } catch (SQLException e) {
         System.out.println("Error de conexión o consulta: " + e.getMessage());
     	}
 	}
}

public class Main {
	//Crear nuevo objeto menu
	 public static void main(String[] args) {
	     Menu menu = new Menu();
	     menu.menu();
	 }
}