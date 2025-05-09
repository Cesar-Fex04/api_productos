import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import java.util.Scanner;


// compilar: javac TestApi.java
// ejecutar: java -cp . TestApi

public class TestApi {
    public static void main(String[] args) {
        Scanner sc = new Scanner(System.in);
        System.out.print("Escribe el código del producto a buscar: ");
        String codigo = sc.nextLine().trim();
        sc.close();

        String url = "http://localhost/apis/buscar_producto.php?codigo=" + codigo;

        try {
            URL obj = new URL(url);
            HttpURLConnection con = (HttpURLConnection) obj.openConnection();
            con.setRequestMethod("GET");
            con.setRequestProperty("Accept", "application/json");

            int responseCode = con.getResponseCode();
            System.out.println("Código de respuesta HTTP: " + responseCode);

            BufferedReader in;
            if (responseCode >= 200 && responseCode < 400) {
                in = new BufferedReader(new InputStreamReader(con.getInputStream(), "UTF-8"));
            } else {
                in = new BufferedReader(new InputStreamReader(con.getErrorStream(), "UTF-8"));
            }

            String inputLine;
            StringBuilder response = new StringBuilder();
            while ((inputLine = in.readLine()) != null) {
                response.append(inputLine);
            }
            in.close();

            System.out.println("Respuesta del servidor:");
            System.out.println(response.toString());

        } catch (Exception e) {
            System.err.println("Error al conectarse con la API:");
            e.printStackTrace();
        }
    }
}
