package principal;

import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.FileWriter;
import java.util.ArrayList;
import java.util.Iterator;
import java.util.StringTokenizer;

import org.apache.hadoop.fs.Path;
import org.apache.hadoop.io.IntWritable;
import org.apache.hadoop.io.Text;
import org.apache.hadoop.mapreduce.Job;
import org.apache.hadoop.mapreduce.lib.input.FileInputFormat;
import org.apache.hadoop.mapreduce.lib.output.FileOutputFormat;
import org.apache.hadoop.mapreduce.lib.output.TextOutputFormat;


// Les datas sont dans le fichier couleurs.csv
// Le fichier de sortie peut être nommé resultat.txt
// Les paramètres seront les valeurs de rouge, vert et bleu de la couleur cherchée
// Le paramètre est fixé à 3

public class Main {

	public static int r;
	public static int v;
	public static int b;
	
	public static void main(String[] args)throws Exception {
	       
	    algoMapReduce(args);

	}

	private static void algoClassique(String[] args) {
		
	   String text = "";
	   try (FileReader fr = new FileReader("couleurs.csv") 	) {			           
	        int i;
	        while ((i = fr.read()) != -1) {
				text += (char)i;
			}
	   }
	   catch(Exception ex) {
		   System.out.println("Erreur pendabnt la lecture");
	   }
          
	   
       ArrayList<Couleur> couleurs = new ArrayList<Couleur>();
       
       StringTokenizer st = new StringTokenizer(text,"\r");			// Itérateur sur les lignes du fichier
	
       st.nextElement();	// Echapper la ligne de titre
       
       while(st.hasMoreTokens()) {									// Lire les couleurs 
    	   String ligne = st.nextToken();
    	   if(ligne.length() > 2) {
	    	   Couleur coul = new Couleur(ligne);
	    	   couleurs.add(coul);
    	   }
       }
       
       int r = Integer.parseInt(args[0]);				// Récupération des valeurs de couleurs r, v, b
       int v = Integer.parseInt(args[1]);
       int b = Integer.parseInt(args[2]);
       
       double distMini1 = 999999; int etiqMini1 = 0;
       double distMini2 = 999999; int etiqMini2 = 0;
       double distMini3 = 999999; int etiqMini3 = 0;
       Iterator<Couleur> it = couleurs.iterator();
       while(it.hasNext()) {
    	   Couleur c = it.next();
    	   c.setDistance(  Math.sqrt( (c.getR() - r) ^ 2 + (c.getV() - v) ^ 2 + (c.getB() - b) ^ 2 ));
    	   
    	   if(c.getDistance() < distMini1) {distMini1 = c.getDistance(); etiqMini1 = c.getEtiquette(); }
    	   if(c.getDistance() < distMini2 && c.getDistance() > distMini1 ) {distMini2 = c.getDistance(); etiqMini2 = c.getEtiquette(); }
    	   if(c.getDistance() < distMini3 && c.getDistance() > distMini2 ) {distMini3 = c.getDistance(); etiqMini3 = c.getEtiquette(); }
       }
       
       int result1 = etiqMini1 + etiqMini2 + etiqMini3;
       String result2;
       if(result1 < 0) 		{result2 = "Froide";}
       else if(result1 > 0) {result2 = "Chaude";}
       else 				{result2 = "Neutre";}
       
       try (FileWriter fw = new FileWriter("resultat.txt")) {
			fw.write(result2);
		} 
       catch (Exception e) {
			e.printStackTrace();
       }
	}
	
	private static void algoMapReduce(String[] args) throws Exception {
	       r = Integer.parseInt(args[0]);				// Récupération des valeurs de couleurs r, v, b
	       v = Integer.parseInt(args[1]);
	       b = Integer.parseInt(args[2]);

			//Initialise le job Hadop 
			Job job = new Job();
			job.setJarByClass(Main.class);
			job.setJobName("Knn");
			
			//Fixe les chemins d'accès aux fichiers d'entrée et de sortie
			FileInputFormat.addInputPath(job, new Path("couleurs.csv"));
			FileOutputFormat.setOutputPath(job, new Path("resultat.txt"));
		
			job.setOutputKeyClass(Text.class);
			job.setOutputValueClass(IntWritable.class);
			job.setOutputFormatClass(TextOutputFormat.class);
			
			//Associe le mapper et le reducer
			job.setMapperClass(MapClass.class);
			job.setReducerClass(ReduceClass.class);
		
			//Attend la fin du traitement :
			int returnValue = job.waitForCompletion(true) ? 0:1;
			
			if(job.isSuccessful()) {
				System.out.println("Travail terminé");
			} else if(!job.isSuccessful()) {
				System.out.println("Erreur pendant l'exécution de la tâche");			
			}

	}
	
}
