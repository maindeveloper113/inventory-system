package com.inventory.cis;

import android.app.Activity;
import android.content.Context;
import android.content.res.Resources;
import android.graphics.Bitmap;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageView;
import android.widget.TextView;

import org.w3c.dom.Text;

import java.util.ArrayList;

/********* Adapter class extends with BaseAdapter and implements with OnClickListener ************/
public class CustomAdapter extends BaseAdapter   implements OnClickListener {
    
	/*********** Declare Used Variables *********/
    private Activity activity;
    private ArrayList data;
    private static LayoutInflater inflater=null;
    public Resources res;
    ListModel tempValues=null;
    int i=0;
    Context contextMain;
    public ImageLoader imageLoader;


    /*************  CustomAdapter Constructor *****************/
    public CustomAdapter(Activity a, ArrayList d, Context context) {
    	
    	/********** Take passed values **********/
        activity = a;
        data=d;
        contextMain = context;
        
        /***********  Layout inflator to call external xml layout () **********************/
        inflater = (LayoutInflater)activity.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

        imageLoader = new ImageLoader(activity.getApplicationContext());
        
    }

    /******** What is the size of Passed Arraylist Size ************/
    public int getCount() {
    	
    	if(data.size()<=0)
    		return 1;
        return data.size();
    }

    public Object getItem(int position) {
        return position;
    }

    public long getItemId(int position) {
        return position;
    }
    
    /********* Create a holder to contain inflated xml file elements ***********/
    public static class ViewHolder{

        public TextView txt_location;
        public TextView txt_partnum;
        public TextView txt_serialnum;
        public TextView txt_description;
        public ImageView image;
        public TextView txt_remark;
        public TextView txt_quantity;

    }


    /*********** Depends upon data size called for each row , Create each ListView row ***********/
    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
    	
        View vi=convertView;
        ViewHolder holder;
        
        if(convertView==null){ 
        	
        	/********** Inflate tabitem.xml file for each row ( Defined below ) ************/
            vi = inflater.inflate(R.layout.tabitem, null);
            
            /******** View Holder Object to contain tabitem.xml file elements ************/
            holder=new ViewHolder();
            holder.txt_location=(TextView)vi.findViewById(R.id.txt_location);
            holder.txt_partnum=(TextView)vi.findViewById(R.id.txt_partnum);
            holder.txt_serialnum=(TextView)vi.findViewById(R.id.txt_serialnum);
            holder.txt_remark=(TextView)vi.findViewById(R.id.txt_remark);
            holder.txt_description = (TextView)vi.findViewById(R.id.txt_description);
            holder.image=(ImageView)vi.findViewById(R.id.image);
            holder.txt_quantity = (TextView)vi.findViewById(R.id.txt_quantity);
            
           /************  Set holder with LayoutInflater ************/
            vi.setTag(holder);
        }
        else  
            holder=(ViewHolder)vi.getTag();
        
        if(data.size()<=0)
        {
        	holder.txt_location.setText("No Data");
            holder.txt_remark.setText("");
            holder.txt_description.setText("");
            holder.txt_serialnum.setText("");
            holder.txt_partnum.setText("");
            holder.txt_quantity.setText("");
            holder.image.setImageResource(R.drawable.placeholder);

        }
        else
        {
        	/***** Get each Model object from Arraylist ********/
	        tempValues=null;
	        tempValues = (ListModel) data.get(position);
	        holder.txt_location.setText(tempValues.getLocation());
            holder.txt_remark.setText(tempValues.getRemark());
            holder.txt_partnum.setText(tempValues.getInventoryPartnumber());
            holder.txt_serialnum.setText(tempValues.getInventorySerialnumber());
            holder.txt_description.setText(tempValues.getDescription());
            holder.txt_quantity.setText(String.valueOf(tempValues.getQuantity()));

            ImageView image = holder.image;
            String imageUrl = tempValues.getImage();
            imageLoader.DisplayImage(imageUrl, image);

//            int loader = R.drawable.placeholder;
//
//            // ImageLoader class instance
//            ImageLoader imgLoader = new ImageLoader(contextMain);
//
//            String imageUrl = tempValues.getImage();
//            imgLoader.DisplayImage(imageUrl, loader, holder.image);



            vi.setOnClickListener(new OnItemClickListener(position));
        }
        return vi;
    }

    @Override
    public void onClick(View v) {
            Log.v("CustomAdapter", "=====Row button clicked");
    }
    
    /********* Called when Item click in ListView ************/
    private class OnItemClickListener  implements OnClickListener{           
        private int mPosition;
        
        OnItemClickListener(int position){
        	 mPosition = position;
        }
        
        @Override
        public void onClick(View arg0) {
            ViewInventoryActicity sct = (ViewInventoryActicity) activity;
        	sct.onItemClick(mPosition);
        }               
    }



}